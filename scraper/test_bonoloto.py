import scraper
import json

# Crear scraper para Bonoloto
scraper_instance = scraper.LotoluckScraper('bonoloto')
result = scraper_instance.scrape()

print('=== RESULTADO CORREGIDO BONOLOTO ===')
for premio in result['premios']:
    print(f"Categoría: {premio['categoria']}, Aciertos: {premio['aciertos']}, Acertantes: {premio['acertantes']}, Premio: {premio['premio']}€")
