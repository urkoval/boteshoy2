#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
Conexión a la base de datos SQLite de Laravel
"""

import sqlite3
import json
import logging
from datetime import datetime
from config import DB_PATH

logger = logging.getLogger(__name__)

class Database:
    def __init__(self):
        self.conn = None
        self.cursor = None
    
    def connect(self):
        """Conectar a la base de datos"""
        try:
            self.conn = sqlite3.connect(DB_PATH)
            self.cursor = self.conn.cursor()
            logger.info(f"Conectado a la base de datos: {DB_PATH}")
            return True
        except Exception as e:
            logger.error(f"Error al conectar a la base de datos: {e}")
            return False
    
    def delete_sorteo(self, slug, fecha):
        """Eliminar un sorteo específico"""
        try:
            self.cursor.execute("DELETE FROM sorteos WHERE slug = ? AND fecha = ?", (slug, fecha))
            self.conn.commit()
            logger.info(f"Sorteo eliminado: {slug} - {fecha}")
            return True
        except Exception as e:
            logger.error(f"Error al eliminar sorteo: {e}")
            return False

    def close(self):
        """Cerrar conexión"""
        if self.conn:
            self.conn.close()
            logger.info("Conexión cerrada")

    def ensure_botes_table(self):
        """Crear tabla de botes si no existe"""
        try:
            self.cursor.execute("""
                CREATE TABLE IF NOT EXISTS botes (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    juego_slug TEXT NOT NULL,
                    fecha_sorteo TEXT NOT NULL,
                    bote_eur INTEGER NOT NULL,
                    source_url TEXT,
                    created_at TEXT,
                    updated_at TEXT,
                    UNIQUE(juego_slug, fecha_sorteo)
                )
            """)
            self.conn.commit()
            return True
        except Exception as e:
            logger.error(f"Error al crear tabla botes: {e}")
            return False

    def insert_bote(self, juego_slug, fecha_sorteo, bote_eur, source_url=None):
        """Insertar bote histórico (ignora si ya existe)"""
        try:
            now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            self.cursor.execute(
                """
                INSERT OR IGNORE INTO botes (juego_slug, fecha_sorteo, bote_eur, source_url, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?)
                """,
                (juego_slug, fecha_sorteo, int(bote_eur), source_url, now, now),
            )
            self.conn.commit()
            inserted = self.cursor.rowcount > 0
            if inserted:
                logger.info(f"Bote insertado: {juego_slug} - {fecha_sorteo} - {bote_eur}")
            else:
                logger.info(f"Bote ya existe: {juego_slug} - {fecha_sorteo}")
            return inserted
        except Exception as e:
            logger.error(f"Error al insertar bote: {e}")
            return False
    
    def get_juego_id(self, slug):
        """Obtener ID del juego por slug"""
        try:
            self.cursor.execute("SELECT id FROM juegos WHERE slug = ?", (slug,))
            result = self.cursor.fetchone()
            if result:
                return result[0]
            logger.error(f"Juego no encontrado: {slug}")
            return None
        except Exception as e:
            logger.error(f"Error al obtener juego: {e}")
            return None
    
    def sorteo_exists(self, juego_id, fecha):
        """Verificar si ya existe un sorteo para esa fecha"""
        try:
            self.cursor.execute(
                "SELECT id FROM sorteos WHERE juego_id = ? AND fecha = ?",
                (juego_id, fecha)
            )
            return self.cursor.fetchone() is not None
        except Exception as e:
            logger.error(f"Error al verificar sorteo: {e}")
            return False

    def get_sorteo_id(self, juego_id, fecha):
        """Obtener ID de sorteo existente"""
        try:
            self.cursor.execute(
                "SELECT id FROM sorteos WHERE juego_id = ? AND fecha = ?",
                (juego_id, fecha)
            )
            row = self.cursor.fetchone()
            return row[0] if row else None
        except Exception as e:
            logger.error(f"Error al obtener sorteo: {e}")
            return None

    def sorteo_premios_is_empty(self, sorteo_id):
        """Detecta si el campo premios está vacío (NULL, [], o {})"""
        try:
            self.cursor.execute("SELECT premios FROM sorteos WHERE id = ?", (sorteo_id,))
            row = self.cursor.fetchone()
            if not row:
                return True
            premios = row[0]
            if premios is None:
                return True
            premios_str = str(premios).strip()
            if premios_str in ('', 'null', '[]', '{}'):
                return True

            # Si es JSON con todas las categorías a 0 (acertantes y premio), lo tratamos como "vacío".
            try:
                parsed = json.loads(premios_str)
                if isinstance(parsed, list) and len(parsed) > 0:
                    all_zero = True
                    for p in parsed:
                        if not isinstance(p, dict):
                            all_zero = False
                            break
                        if int(p.get('acertantes') or 0) != 0:
                            all_zero = False
                            break
                        if float(p.get('premio') or 0) != 0:
                            all_zero = False
                            break
                    if all_zero:
                        return True

                    # Caso típico: hay acertantes pero el importe está pendiente (0/None/"acumulado").
                    # Lo tratamos como "vacío" para que el scraper pueda actualizar cuando el importe llegue.
                    for p in parsed:
                        if not isinstance(p, dict):
                            continue
                        acertantes = int(p.get('acertantes') or 0)
                        premio = p.get('premio')
                        premio_val = float(premio or 0) if premio is not None else 0
                        if acertantes > 0 and premio_val == 0:
                            return True
            except Exception:
                pass

            return False
        except Exception as e:
            logger.error(f"Error al comprobar premios: {e}")
            return True

    def update_premios_if_empty(self, slug, fecha, premios):
        """Actualizar premios solo si antes estaban vacíos"""
        try:
            juego_id = self.get_juego_id(slug)
            if not juego_id:
                return False

            sorteo_id = self.get_sorteo_id(juego_id, fecha)
            if not sorteo_id:
                return False

            if not self.sorteo_premios_is_empty(sorteo_id):
                return False

            now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            self.cursor.execute(
                "UPDATE sorteos SET premios = ?, updated_at = ? WHERE id = ?",
                (json.dumps(premios), now, sorteo_id)
            )
            self.conn.commit()
            updated = self.cursor.rowcount > 0
            if updated:
                logger.info(f"Premios actualizados: {slug} - {fecha}")
            return updated
        except Exception as e:
            logger.error(f"Error al actualizar premios: {e}")
            return False
    
    def insert_sorteo(self, slug, fecha, numeros, complementarios=None, bote=None, premios=None, localidades=None):
        """Insertar un nuevo sorteo"""
        try:
            juego_id = self.get_juego_id(slug)
            if not juego_id:
                return False
            
            # Verificar si ya existe
            if self.sorteo_exists(juego_id, fecha):
                updated = False
                if premios:
                    updated = self.update_premios_if_empty(slug=slug, fecha=fecha, premios=premios)
                if updated:
                    return True
                logger.info(f"Sorteo ya existe: {slug} - {fecha}")
                return False
            
            now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            
            self.cursor.execute("""
                INSERT INTO sorteos (juego_id, fecha, numeros, complementarios, bote, premios, localidades, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            """, (
                juego_id,
                fecha,
                json.dumps(numeros),
                json.dumps(complementarios) if complementarios else None,
                bote,
                json.dumps(premios) if premios else None,
                json.dumps(localidades) if localidades else None,
                now,
                now
            ))
            
            self.conn.commit()
            logger.info(f"Sorteo insertado: {slug} - {fecha}")
            return True
            
        except Exception as e:
            logger.error(f"Error al insertar sorteo: {e}")
            return False
