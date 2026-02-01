#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
Configuración del scraper
"""

import os
from pathlib import Path

# Directorio base
BASE_DIR = Path(__file__).parent
PROJECT_DIR = BASE_DIR.parent

# Base de datos Laravel (SQLite)
DB_PATH = PROJECT_DIR / "web" / "database" / "database.sqlite"

# URLs de Lotoluck
URLS = {
    'bonoloto': 'https://lotoluck.com/juegos/onlae/bonoloto',
    'euromillones': 'https://lotoluck.com/juegos/onlae/euromillones',
    'la-primitiva': 'https://lotoluck.com/juegos/onlae/primitiva',
    'el-gordo': 'https://lotoluck.com/juegos/onlae/el-gordo',
}

# Página agregada de botes
BOTES_URL = 'https://lotoluck.com/botes'

# Configuración de scraping SOFT
REQUEST_DELAY_MIN = 3  # segundos mínimo entre requests
REQUEST_DELAY_MAX = 7  # segundos máximo entre requests

# Headers para parecer un navegador real
HEADERS = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Accept-Language': 'es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3',
    'Connection': 'keep-alive',
    'Upgrade-Insecure-Requests': '1',
    'Cache-Control': 'max-age=0'
}
