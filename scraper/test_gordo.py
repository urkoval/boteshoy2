import scraper
import json

# Crear scraper para El Gordo
scraper_instance = scraper.LotoluckScraper('el-gordo')
result = scraper_instance.scrape()

print('=== DATOS CORREGIDOS ===')
for premio in result['premios'][:3]:  # Primeras 3 categorías
    print(f"Categoría: {premio['categoria']}, Aciertos: {premio['aciertos']}, Acertantes: {premio['acertantes']}, Premio: {premio['premio']}€")
