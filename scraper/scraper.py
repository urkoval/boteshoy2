#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
Scraper para loterías desde lotoluck.com
Versión SOFT: delays largos, un solo request por ejecución
"""

import re
import logging
import time
import random
from datetime import datetime
import unicodedata
import requests
from bs4 import BeautifulSoup

from config import URLS, BOTES_URL, HEADERS, REQUEST_DELAY_MIN, REQUEST_DELAY_MAX
from database import Database

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)


class LotoluckScraper:
    """Scraper genérico para lotoluck.com"""
    
    def __init__(self, slug):
        self.slug = slug
        self.url = URLS.get(slug)
        if not self.url:
            raise ValueError(f"Juego no soportado: {slug}")
    
    def _soft_delay(self):
        """Espera aleatoria para ser amable con el servidor"""
        delay = random.uniform(REQUEST_DELAY_MIN, REQUEST_DELAY_MAX)
        logger.info(f"Esperando {delay:.1f} segundos...")
        time.sleep(delay)
    
    def _get_soup(self):
        """Obtener BeautifulSoup de la página"""
        try:
            logger.info(f"Descargando: {self.url}")
            response = requests.get(self.url, headers=HEADERS, timeout=30)
            response.raise_for_status()
            return BeautifulSoup(response.text, 'html.parser')
        except Exception as e:
            logger.error(f"Error al descargar {self.url}: {e}")
            return None
    
    def _extract_number_from_image(self, src):
        """Extraer número del nombre de archivo de imagen (Bola48.gif -> 48)"""
        match = re.search(r'Bola(\d+)\.gif', src)
        if match:
            return int(match.group(1))
        return None
    
    def _extract_date(self, soup):
        """Extraer fecha del sorteo"""
        try:
            # Buscar fecha en formato DD/MM/YYYY
            text = soup.get_text()
            match = re.search(r'(\d{1,2}/\d{1,2}/\d{4})', text)
            if match:
                day, month, year = match.group(1).split('/')
                return f"{year}-{month.zfill(2)}-{day.zfill(2)}"
        except Exception as e:
            logger.error(f"Error extrayendo fecha: {e}")
        
        return datetime.now().strftime("%Y-%m-%d")
    
    def _extract_numbers(self, soup):
        """Extraer números principales"""
        numbers = []
        try:
            table = soup.find('table', class_='modulo_resultados')
            if table:
                rows = table.find_all('tr')
                if len(rows) >= 2:
                    cells = rows[1].find_all('td')
                    if len(cells) >= 2:
                        images = cells[1].find_all('img', src=lambda s: s and 'Bola' in s)
                        for img in images:
                            num = self._extract_number_from_image(img['src'])
                            if num:
                                numbers.append(num)
            
            # Método alternativo
            if not numbers:
                tables = soup.find_all('table')
                if tables:
                    images = tables[0].find_all('img', src=lambda s: s and 'Bola' in s)
                    for img in images[:6]:  # Máximo 6 números principales
                        num = self._extract_number_from_image(img['src'])
                        if num:
                            numbers.append(num)
            
            numbers = sorted(numbers)
        except Exception as e:
            logger.error(f"Error extrayendo números: {e}")
        
        return numbers
    
    def _extract_complementarios(self, soup):
        """Extraer complementarios (varía según juego)"""
        complementarios = {}
        
        try:
            table = soup.find('table', class_='modulo_resultados')
            if table:
                rows = table.find_all('tr')
                if len(rows) >= 2:
                    cells = rows[1].find_all('td')
                    
                    # Bonoloto / Primitiva: Complementario (C) y Reintegro (R)
                    if self.slug in ['bonoloto', 'la-primitiva']:
                        if len(cells) >= 4:
                            img = cells[3].find('img', src=lambda s: s and 'Bola' in s)
                            if img:
                                complementarios['complementario'] = self._extract_number_from_image(img['src'])
                        if len(cells) >= 5:
                            img = cells[4].find('img', src=lambda s: s and 'Bola' in s)
                            if img:
                                complementarios['reintegro'] = self._extract_number_from_image(img['src'])
                    
                    # Euromillones: Estrellas (están en spans, no en imágenes)
                    elif self.slug == 'euromillones':
                        estrellas = []
                        spans = table.find_all('span', class_='result_estrella')
                        for span in spans:
                            try:
                                num = int(span.get_text(strip=True))
                                estrellas.append(num)
                            except:
                                pass
                        if estrellas:
                            complementarios['estrellas'] = sorted(estrellas)
                    
                    # El Gordo: Número Clave (está en cells[3])
                    elif self.slug == 'el-gordo':
                        if len(cells) >= 4:
                            img = cells[3].find('img', src=lambda s: s and 'Bola' in s)
                            if img:
                                complementarios['clave'] = self._extract_number_from_image(img['src'])
        
        except Exception as e:
            logger.error(f"Error extrayendo complementarios: {e}")
        
        return complementarios if complementarios else None
    
    def _extract_premios(self, soup):
        """Extraer tabla de premios"""
        premios = []
        
        try:
            tables = soup.find_all('table')
            if len(tables) > 1:
                prize_table = tables[1]
                rows = prize_table.find_all('tr')
                
                for row in rows[2:]:  # Saltar encabezados
                    cells = row.find_all('td')
                    
                    # Euromillones tiene 5 columnas: Categoria, Aciertos, Acertantes Europa, Acertantes España, Premios
                    if self.slug == 'euromillones' and len(cells) >= 5:
                        categoria = cells[0].get_text(strip=True)
                        aciertos = cells[1].get_text(strip=True)
                        acertantes_europa_text = cells[2].get_text(strip=True)
                        acertantes_espana_text = cells[3].get_text(strip=True)
                        premio_text = cells[4].get_text(strip=True)
                        
                        # Limpiar números
                        try:
                            acertantes_europa = int(re.sub(r'[^\d]', '', acertantes_europa_text) or 0)
                        except:
                            acertantes_europa = 0
                            
                        try:
                            acertantes_espana = int(re.sub(r'[^\d]', '', acertantes_espana_text) or 0)
                        except:
                            acertantes_espana = 0

                        def _parse_euro_amount(text):
                            raw = re.sub(r'[^\d,.]', '', (text or '')).strip()
                            if not raw:
                                return None

                            # Formato típico ES: 1.234,56 -> 1234.56
                            if '.' in raw and ',' in raw:
                                raw = raw.replace('.', '').replace(',', '.')
                            elif ',' in raw:
                                raw = raw.replace(',', '.')

                            try:
                                return float(raw)
                            except Exception:
                                return None

                        premio = _parse_euro_amount(premio_text)

                        # Si no hay ningún dígito, probablemente es "Acumulado / Pendiente / ---".
                        # Si hay acertantes, lo tratamos como pendiente (None). Si no hay acertantes, es 0.
                        if not re.search(r'\d', premio_text or ''):
                            premio = None if (acertantes_europa + acertantes_espana) > 0 else 0
                        
                        if categoria:
                            premios.append({
                                'categoria': categoria,
                                'aciertos': aciertos,
                                'acertantes_europa': acertantes_europa,
                                'acertantes_espana': acertantes_espana,
                                'premio': premio
                            })
                    
                    # El Gordo tiene 4 columnas: Categoria, Aciertos, Acertantes, Premios
                    elif self.slug == 'el-gordo' and len(cells) >= 4:
                        categoria = cells[0].get_text(strip=True)
                        aciertos = cells[1].get_text(strip=True)  # 5+1, 5+0, etc.
                        acertantes_text = cells[2].get_text(strip=True)  # número de ganadores
                        premio_text = cells[3].get_text(strip=True)  # importe del premio
                        
                        # Limpiar número de acertantes
                        try:
                            acertantes = int(re.sub(r'[^\d]', '', acertantes_text) or 0)
                        except:
                            acertantes = 0

                        def _parse_euro_amount(text):
                            raw = re.sub(r'[^\d,.]', '', (text or '')).strip()
                            if not raw:
                                return None

                            # Formato típico ES: 1.234,56 -> 1234.56
                            if '.' in raw and ',' in raw:
                                raw = raw.replace('.', '').replace(',', '.')
                            elif ',' in raw:
                                raw = raw.replace(',', '.')

                            try:
                                return float(raw)
                            except Exception:
                                return None

                        premio = _parse_euro_amount(premio_text)

                        # Si no hay ningún dígito, probablemente es "Acumulado / Pendiente / ---".
                        # Si hay acertantes, lo tratamos como pendiente (None). Si no hay acertantes, es 0.
                        if not re.search(r'\d', premio_text or ''):
                            premio = None if acertantes > 0 else 0
                        
                        if categoria:
                            premios.append({
                                'categoria': categoria,
                                'aciertos': aciertos,
                                'acertantes': acertantes,
                                'premio': premio
                            })
                    
                    # La Primitiva tiene 4 columnas: Categoria, Aciertos, Acertantes, Premios
                    elif self.slug == 'la-primitiva' and len(cells) >= 4:
                        categoria = cells[0].get_text(strip=True)
                        aciertos = cells[1].get_text(strip=True)  # 6+R, 6, 5+C, 5, 4, 3
                        acertantes_text = cells[2].get_text(strip=True)  # número de ganadores
                        premio_text = cells[3].get_text(strip=True)  # importe del premio
                        
                        # Limpiar número de acertantes
                        try:
                            acertantes = int(re.sub(r'[^\d]', '', acertantes_text) or 0)
                        except:
                            acertantes = 0

                        def _parse_euro_amount(text):
                            raw = re.sub(r'[^\d,.]', '', (text or '')).strip()
                            if not raw:
                                return None

                            # Formato típico ES: 1.234,56 -> 1234.56
                            if '.' in raw and ',' in raw:
                                raw = raw.replace('.', '').replace(',', '.')
                            elif ',' in raw:
                                raw = raw.replace(',', '.')

                            try:
                                return float(raw)
                            except Exception:
                                return None

                        premio = _parse_euro_amount(premio_text)

                        # Si no hay ningún dígito, probablemente es "Acumulado / Pendiente / ---".
                        # Si hay acertantes, lo tratamos como pendiente (None). Si no hay acertantes, es 0.
                        if not re.search(r'\d', premio_text or ''):
                            premio = None if acertantes > 0 else 0
                        
                        if categoria:
                            premios.append({
                                'categoria': categoria,
                                'aciertos': aciertos,
                                'acertantes': acertantes,
                                'premio': premio
                            })
                    
                    # Bonoloto tiene 4 columnas: Categoria, Aciertos, Acertantes, Premios
                    elif self.slug == 'bonoloto' and len(cells) >= 4:
                        categoria = cells[0].get_text(strip=True)
                        aciertos = cells[1].get_text(strip=True)  # 6, 5+C, 5, 4, 3, R
                        acertantes_text = cells[2].get_text(strip=True)  # número de ganadores
                        premio_text = cells[3].get_text(strip=True)  # importe del premio
                        
                        # Limpiar número de acertantes
                        try:
                            acertantes = int(re.sub(r'[^\d]', '', acertantes_text) or 0)
                        except:
                            acertantes = 0

                        def _parse_euro_amount(text):
                            raw = re.sub(r'[^\d,.]', '', (text or '')).strip()
                            if not raw:
                                return None

                            # Formato típico ES: 1.234,56 -> 1234.56
                            if '.' in raw and ',' in raw:
                                raw = raw.replace('.', '').replace(',', '.')
                            elif ',' in raw:
                                raw = raw.replace(',', '.')

                            try:
                                return float(raw)
                            except Exception:
                                return None

                        premio = _parse_euro_amount(premio_text)

                        # Si no hay ningún dígito, probablemente es "Acumulado / Pendiente / ---".
                        # Si hay acertantes, lo tratamos como pendiente (None). Si no hay acertantes, es 0.
                        if not re.search(r'\d', premio_text or ''):
                            premio = None if acertantes > 0 else 0
                        
                        if categoria:
                            premios.append({
                                'categoria': categoria,
                                'aciertos': aciertos,
                                'acertantes': acertantes,
                                'premio': premio
                            })
                    
                    # Para otros juegos: mantener lógica original (3 columnas)
                    elif len(cells) >= 3:
                        categoria = cells[0].get_text(strip=True)
                        acertantes_text = cells[1].get_text(strip=True)
                        premio_text = cells[2].get_text(strip=True)
                        
                        # Limpiar números
                        try:
                            acertantes = int(re.sub(r'[^\d]', '', acertantes_text) or 0)
                        except:
                            acertantes = 0

                        def _parse_euro_amount(text):
                            raw = re.sub(r'[^\d,.]', '', (text or '')).strip()
                            if not raw:
                                return None

                            # Formato típico ES: 1.234,56 -> 1234.56
                            if '.' in raw and ',' in raw:
                                raw = raw.replace('.', '').replace(',', '.')
                            elif ',' in raw:
                                raw = raw.replace(',', '.')

                            try:
                                return float(raw)
                            except Exception:
                                return None

                        premio = _parse_euro_amount(premio_text)

                        # Si no hay ningún dígito, probablemente es "Acumulado / Pendiente / ---".
                        # Si hay acertantes, lo tratamos como pendiente (None). Si no hay acertantes, es 0.
                        if not re.search(r'\d', premio_text or ''):
                            premio = None if acertantes > 0 else 0
                        
                        if categoria:
                            premios.append({
                                'categoria': categoria,
                                'acertantes': acertantes,
                                'premio': premio
                            })
        
        except Exception as e:
            logger.error(f"Error extrayendo premios: {e}")

        if not premios:
            return None

        # Si todos los premios/acertantes son 0, normalmente significa que el reparto aún no está publicado
        try:
            all_zero = True
            for p in premios:
                if self.slug == 'euromillones':
                    if (p.get('acertantes_europa') or 0) != 0 or (p.get('acertantes_espana') or 0) != 0:
                        all_zero = False
                        break
                else:
                    if (p.get('acertantes') or 0) != 0:
                        all_zero = False
                        break
            
            if all_zero:
                return None
        except:
            pass

        return premios
    
    def scrape(self):
        """Ejecutar scraping"""
        logger.info(f"=== Scraping {self.slug} ===")
        
        soup = self._get_soup()
        if not soup:
            return None
        
        fecha = self._extract_date(soup)
        numeros = self._extract_numbers(soup)
        complementarios = self._extract_complementarios(soup)
        premios = self._extract_premios(soup)
        
        if not numeros:
            logger.error(f"No se encontraron números para {self.slug}")
            return None
        
        result = {
            'slug': self.slug,
            'fecha': fecha,
            'numeros': numeros,
            'complementarios': complementarios,
            'premios': premios
        }
        
        logger.info(f"Resultado: {fecha} - {numeros}")
        return result
    
    def scrape_and_save(self):
        """Scrapear y guardar en BD"""
        result = self.scrape()
        if not result:
            return False
        
        db = Database()
        if not db.connect():
            return False
        
        # Verificar si el sorteo ya existe
        existing = db.get_sorteo(result['slug'], result['fecha'])
        
        if existing:
            # Actualizar si ya existe
            success = db.update_sorteo(
                slug=result['slug'],
                fecha=result['fecha'],
                numeros=result['numeros'],
                complementarios=result['complementarios'],
                premios=result['premios']
            )
        else:
            # Insertar si no existe
            success = db.insert_sorteo(
                slug=result['slug'],
                fecha=result['fecha'],
                numeros=result['numeros'],
                complementarios=result['complementarios'],
                premios=result['premios']
            )
        
        db.close()
        return success


def scrape_all():
    """Scrapear todos los juegos con delays entre cada uno"""
    logger.info("=== Iniciando scraping de todos los juegos ===")
    
    results = {}
    juegos = list(URLS.keys())
    
    for i, slug in enumerate(juegos):
        try:
            scraper = LotoluckScraper(slug)
            success = scraper.scrape_and_save()
            results[slug] = success
            
            # Delay entre juegos (excepto el último)
            if i < len(juegos) - 1:
                scraper._soft_delay()
                
        except Exception as e:
            logger.error(f"Error en {slug}: {e}")
            results[slug] = False
    
    logger.info(f"=== Resultados: {results} ===")
    return results


def scrape_one(slug):
    """Scrapear un solo juego"""
    try:
        scraper = LotoluckScraper(slug)
        return scraper.scrape_and_save()
    except Exception as e:
        logger.error(f"Error: {e}")
        return False


def _parse_ddmmyyyy(date_str):
    try:
        day, month, year = date_str.strip().split('/')
        return f"{year}-{month.zfill(2)}-{day.zfill(2)}"
    except Exception:
        return None


def _parse_bote_to_int(bote_str):
    try:
        s = bote_str.strip()
        s = s.replace('.', '')
        if ',' in s:
            s = s.split(',')[0]
        s = re.sub(r'[^0-9]', '', s)
        return int(s) if s else None
    except Exception:
        return None


def _norm_text(s):
    try:
        s = (s or '').strip().lower()
        s = unicodedata.normalize('NFKD', s)
        s = ''.join(ch for ch in s if not unicodedata.combining(ch))
        s = re.sub(r'\s+', ' ', s)
        return s
    except Exception:
        return (s or '').strip().lower()


def _find_bote_row_container(tag):
    current = tag
    for _ in range(5):
        if current is None:
            return None
        if getattr(current, 'find', None):
            nombre = current.select_one('.bj_nombre')
            fecha = current.select_one('.b_fecha')
            bote = current.select_one('.b_bote')
            if nombre and fecha and bote:
                return current
        current = current.parent
    return None


def scrape_botes():
    logger.info("=== Scraping botes ===")

    try:
        response = requests.get(BOTES_URL, headers=HEADERS, timeout=30)
        response.raise_for_status()
        soup = BeautifulSoup(response.text, 'html.parser')
    except Exception as e:
        logger.error(f"Error al descargar {BOTES_URL}: {e}")
        return False

    name_to_slug = {
        'euromillones': 'euromillones',
        'bonoloto': 'bonoloto',
        'la primitiva': 'la-primitiva',
        'el gordo': 'el-gordo',
    }

    targets = set(name_to_slug.keys())
    found = {}

    for nombre_tag in soup.select('.bj_nombre'):
        nombre_txt = nombre_tag.get_text(strip=True)
        nombre_key = _norm_text(nombre_txt)
        if nombre_key not in targets:
            continue

        row = _find_bote_row_container(nombre_tag)
        if not row:
            continue

        fecha_span = row.select_one('.b_fecha')
        bote_span = row.select_one('.b_bote')
        fecha_txt = None
        bote_txt = None

        if fecha_span:
            s = fecha_span.find('span')
            fecha_txt = (s.get_text(strip=True) if s else fecha_span.get_text(strip=True))
        if bote_span:
            s = bote_span.find('span')
            bote_txt = (s.get_text(strip=True) if s else bote_span.get_text(strip=True))

        fecha_iso = _parse_ddmmyyyy(fecha_txt or '')
        bote_int = _parse_bote_to_int(bote_txt or '')
        if not fecha_iso or bote_int is None:
            continue

        # Si ya existe un bote para este juego, quedarse con el de fecha más cercana
        slug = name_to_slug[nombre_key]
        if slug in found:
            existing_fecha = found[slug]['fecha_sorteo']
            if fecha_iso < existing_fecha:
                # El nuevo es más cercano, reemplazar
                found[slug] = {
                    'fecha_sorteo': fecha_iso,
                    'bote_eur': bote_int,
                    'nombre': nombre_txt,
                    'bote_raw': bote_txt,
                }
            # Si no, mantener el existente (más cercano)
        else:
            found[slug] = {
                'fecha_sorteo': fecha_iso,
                'bote_eur': bote_int,
                'nombre': nombre_txt,
                'bote_raw': bote_txt,
            }

    if not found:
        logger.error("No se encontraron botes en la página")
        return False

    db = Database()
    if not db.connect():
        return False
    if not db.ensure_botes_table():
        db.close()
        return False

    inserted_any = False
    for juego_slug, data in found.items():
        ok = db.insert_bote(
            juego_slug=juego_slug,
            fecha_sorteo=data['fecha_sorteo'],
            bote_eur=data['bote_eur'],
            source_url=BOTES_URL,
        )
        inserted_any = inserted_any or ok

    db.close()
    logger.info(f"=== Botes encontrados: {list(found.keys())} ===")
    return inserted_any


if __name__ == "__main__":
    import sys
    
    if len(sys.argv) > 1:
        slug = sys.argv[1]
        if slug == 'botes':
            scrape_botes()
        else:
            # Scrapear juego específico
            scrape_one(slug)
    else:
        # Scrapear todos
        scrape_all()
