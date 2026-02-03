#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
Script para actualizar sorteos históricos de Euromillones
Usa URLs específicas con juego_seleccionado
"""

import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from scraper import LotoluckScraper
from database import Database
import logging

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# URLs específicas de sorteos históricos
HISTORICAL_URLS = {
    '2026-01-27': 'https://lotoluck.com/juegos/onlae/euromillones?juego_seleccionado=67547',
    '2026-01-23': 'https://lotoluck.com/juegos/onlae/euromillones?juego_seleccionado=67475',
    '2026-01-20': 'https://lotoluck.com/juegos/onlae/euromillones?juego_seleccionado=67420',
}

def scrape_specific_url(url, fecha):
    """Scrapear una URL específica para una fecha determinada"""
    logger.info(f"Scrapeando {fecha} desde {url}")
    
    # Crear scraper personalizado con URL específica
    scraper = LotoluckScraper('euromillones')
    scraper.url = url  # Sobrescribir URL por defecto
    
    # Ejecutar scraping
    result = scraper.scrape()
    if not result:
        logger.error(f"No se pudo obtener datos para {fecha}")
        return False
    
    # Forzar la fecha específica
    result['fecha'] = fecha
    
    # Guardar en BD
    db = Database()
    if not db.connect():
        logger.error("No se pudo conectar a la BD")
        return False
    
    # Eliminar registro existente si lo hay
    db.delete_sorteo('euromillones', fecha)
    
    # Insertar nuevo registro
    success = db.insert_sorteo(
        slug=result['slug'],
        fecha=result['fecha'],
        numeros=result['numeros'],
        complementarios=result['complementarios'],
        premios=result['premios']
    )
    
    db.close()
    
    if success:
        logger.info(f"✅ Sorteo {fecha} actualizado correctamente")
        logger.info(f"   Números: {result['numeros']}")
        if result['complementarios']:
            logger.info(f"   Complementarios: {result['complementarios']}")
        if result['premios']:
            logger.info(f"   Premios: {len(result['premios'])} categorías")
    else:
        logger.error(f"❌ Error al guardar sorteo {fecha}")
    
    return success

def main():
    """Función principal"""
    logger.info("=== Actualizando sorteos históricos de Euromillones ===")
    
    resultados = {}
    
    for fecha, url in HISTORICAL_URLS.items():
        try:
            success = scrape_specific_url(url, fecha)
            resultados[fecha] = success
        except Exception as e:
            logger.error(f"Error procesando {fecha}: {e}")
            resultados[fecha] = False
    
    # Resumen
    logger.info("=== Resumen ===")
    for fecha, success in resultados.items():
        status = "✅ OK" if success else "❌ ERROR"
        logger.info(f"{fecha}: {status}")
    
    # Estadísticas
    exitosos = sum(1 for s in resultados.values() if s)
    logger.info(f"Total: {exitosos}/{len(resultados)} sorteos actualizados")

if __name__ == "__main__":
    main()
