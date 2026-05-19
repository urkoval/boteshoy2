#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""Script para scrapear histórico de Lotería Nacional"""

import sys
import time
sys.path.insert(0, '.')

from scraper import LotoluckScraper
from database import Database

# URLs históricas de Lotería Nacional
urls = [
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69546',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69449',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69416',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69344',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69282',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69186',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69152',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69052',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=69019',
    'https://lotoluck.com/juegos/onlae/loteria-nacional?juego_seleccionado=68921',
]

scraper = LotoluckScraper('loteria-nacional')

for url in urls:
    time.sleep(2)
    print(f"Scraping: {url[-25:]}")
    scraper.url = url
    result = scraper.scrape()
    if result:
        primer = result['complementarios'].get('primer_premio', '?')
        print(f"  -> {result['fecha']} - 1o:{primer}")
        
        db = Database()
        if db.connect():
            existing = db.get_sorteo('loteria-nacional', result['fecha'])
            if not existing:
                db.insert_sorteo(
                    slug='loteria-nacional',
                    fecha=result['fecha'],
                    numeros=result['numeros'],
                    complementarios=result['complementarios'],
                    premios=result['premios']
                )
                print("  -> Guardado")
            else:
                print("  -> Ya existe")
            db.close()
    else:
        print("  -> Error al scrapear")

print("Completado!")
