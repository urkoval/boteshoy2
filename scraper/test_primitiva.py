import scraper
import json

# Crear scraper para La Primitiva
scraper_instance = scraper.LotoluckScraper('la-primitiva')
result = scraper_instance.scrape()

print('=== RESULTADO CORREGIDO LA PRIMITIVA ===')
for premio in result['premios']:
    print(f"Categoría: {premio['categoria']}, Aciertos: {premio['aciertos']}, Acertantes: {premio['acertantes']}, Premio: {premio['premio']}€")
