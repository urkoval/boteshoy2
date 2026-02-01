# Boteshoy 2.0

Web de resultados de loterías españolas. Muestra los últimos sorteos de Euromillones, Bonoloto, La Primitiva y El Gordo de la Primitiva.

**URL producción:** https://boteshoy.com

**Repositorio:** https://github.com/urkoval/boteshoy2 (privado)

## Seguimiento

- [CHANGELOG.md](CHANGELOG.md)
- [ROADMAP.md](ROADMAP.md)

## Estructura del proyecto

```
boteshoy2/
├── web/                    # Laravel 12 (frontend)
│   ├── app/
│   ├── database/
│   ├── resources/views/
│   └── ...
├── scraper/                # Python (obtención de datos)
│   ├── scraper.py
│   ├── database.py
│   ├── config.py
│   └── requirements.txt
├── REQUISITOS.md           # Documento de requisitos
└── README.md
```

## Requisitos

### Web (Laravel)
- PHP 8.2+
- Composer

### Scraper (Python)
- Python 3.9+
- requests, beautifulsoup4

## Instalación local

### 1. Configurar Laravel
```bash
cd web
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=JuegosSeeder
```

### 2. Configurar Scraper
```bash
cd ../scraper
pip install -r requirements.txt
```

## Uso local

### Servidor de desarrollo
```bash
cd web
php artisan serve
# Acceder a http://127.0.0.1:8000
```

### Ejecutar scraper
```bash
cd scraper

# Un juego específico
python scraper.py bonoloto
python scraper.py euromillones
python scraper.py la-primitiva
python scraper.py el-gordo

# Botes actuales (jackpots)
python scraper.py botes

# Todos los juegos (con delays de 3-7s entre cada uno)
python scraper.py
```

## Premios (pendiente vs 0)

- Si la fuente devuelve textos no numéricos en el importe (por ejemplo: "pendiente", "acumulado", "—"), el scraper guarda `premio = null` **solo si hay acertantes > 0**.
- Si `acertantes == 0`, el premio se guarda como `0`.
- El scraper soporta importes con formato ES (por ejemplo `1.234,56 €`).
- La web muestra **"Pendiente"** cuando el importe es `null`.

## Juegos soportados

| Juego | Slug | Días de sorteo | Complementarios |
|-------|------|----------------|-----------------|
| Euromillones | `euromillones` | Martes, Viernes | 2 estrellas |
| Bonoloto | `bonoloto` | Lunes a Domingo | Complementario + Reintegro |
| La Primitiva | `la-primitiva` | Lunes, Jueves, Sábado | Complementario + Reintegro |
| El Gordo | `el-gordo` | Domingo | Número Clave |

## URLs

| Ruta | Descripción |
|------|-------------|
| `/` | Home con últimos resultados |
| `/{juego}/` | Histórico de un juego |
| `/{juego}/{fecha}/` | Sorteo específico (fecha: YYYY-MM-DD) |
| `/sitemap.xml` | Sitemap dinámico |

## Deploy en RunCloud (vía Git)

El deploy se realiza mediante `git pull` desde el repositorio GitHub.

### Configuración inicial

1. **Crear Empty Web App** en RunCloud
2. **Public Path:** `/home/runcloud/webapps/NOMBRE_APP/web/public`
3. **PHP Version:** 8.2+
4. **Clonar el repo:**
   ```bash
   cd /home/runcloud/webapps/NOMBRE_APP
   git clone https://github.com/urkoval/boteshoy2.git .
   ```

### Archivos no versionados (creados manualmente en servidor)

- `web/.env` - Configuración de Laravel (no subir a Git)
- `web/database/database.sqlite` - Base de datos SQLite
- `web/storage/` - Cachés y logs

### Comandos SSH post-clone/inicial

```bash
cd /home/runcloud/webapps/NOMBRE_APP/web

# Instalar dependencias
/usr/local/lsws/lsphp82/bin/php /usr/sbin/composer install --no-dev --optimize-autoloader

# Configurar Laravel
cp .env.example .env
/usr/local/lsws/lsphp82/bin/php artisan key:generate
/usr/local/lsws/lsphp82/bin/php artisan migrate --force
/usr/local/lsws/lsphp82/bin/php artisan db:seed --class=JuegosSeeder --force

# Permisos
sudo chown -R runcloud:runcloud /home/runcloud/webapps/NOMBRE_APP
chmod -R 775 storage bootstrap/cache
```

### Instalar scraper en servidor

```bash
cd /home/runcloud/webapps/NOMBRE_APP/scraper
pip3 install -r requirements.txt
```

### Crons en RunCloud

- **Vendor Binary:** dejarlo **vacío**. Si seleccionas `/bin/bash`, RunCloud antepone `/bin/bash` al comando y puede romperlo.
- **User:** `runcloud`

| Juego | Schedule | Comando |
|-------|----------|---------|
| Bonoloto | `0 21,22,23 * * *` | `cd /home/runcloud/webapps/NOMBRE_APP/scraper && /usr/bin/python3 scraper.py bonoloto` |
| Euromillones | `3 21,22,23 * * 2,5` | `cd /home/runcloud/webapps/NOMBRE_APP/scraper && /usr/bin/python3 scraper.py euromillones` |
| La Primitiva | `6 21,22,23 * * 1,4,6` | `cd /home/runcloud/webapps/NOMBRE_APP/scraper && /usr/bin/python3 scraper.py la-primitiva` |
| El Gordo | `9 21,22,23 * * 0` | `cd /home/runcloud/webapps/NOMBRE_APP/scraper && /usr/bin/python3 scraper.py el-gordo` |

Recomendación: los schedules con 3 ejecuciones (21/22/23) sirven como reintentos para capturar los premios si la fuente los publica con retraso.

### Actualizar servidor (deploy por Git)

1. **En tu PC local:** subir cambios a GitHub
   ```bash
   git add -A
   git commit -m "descripción del cambio"
   git push origin main
   ```

2. **En el servidor (SSH):** actualizar desde GitHub
   ```bash
   cd /home/runcloud/webapps/NOMBRE_APP
   git pull
   cd web
   /usr/local/lsws/lsphp82/bin/php artisan view:clear
   /usr/local/lsws/lsphp82/bin/php artisan config:clear
   /usr/local/lsws/lsphp82/bin/php artisan cache:clear
   ```

3. Si cambias dependencias PHP:
   ```bash
   /usr/local/lsws/lsphp82/bin/php /usr/sbin/composer install --no-dev --optimize-autoloader
   ```

4. Si cambias migraciones:
   ```bash
   /usr/local/lsws/lsphp82/bin/php artisan migrate --force
   ```

### Flujo de trabajo Git (resumen)

- **Local:** trabajar → `git add` → `git commit` → `git push`
- **Servidor:** `git pull` → limpiar cachés (view/config/cache)

### Redirecciones SEO

Para preservar SEO desde URLs antiguas, se han configurado redirecciones 301 en `.htaccess`:

| Antigua | Nueva |
|---------|-------|
| `/lottery/primitiva` | `/la-primitiva` |
| `/lottery/euromillones` | `/euromillones` |
| `/lottery/bonoloto` | `/bonoloto` |
| `/lottery/elgordo` | `/el-gordo` |
| `/about` | `/` |

Las reglas están en `web/public/.htaccess` y se aplican a nivel de webserver.

## Stack técnico

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Blade, Tailwind CSS (CDN)
- **Base de datos:** SQLite
- **Scraper:** Python 3, requests, BeautifulSoup
- **Fuente de datos:** lotoluck.com
- **Hosting:** RunCloud (OpenLiteSpeed)

## Notas

- El scraper está configurado como "soft": delays largos entre requests para no sobrecargar la fuente
- La web es mobile-first y responsive
- SEO básico incluido: títulos dinámicos, meta descriptions, URLs limpias, sitemap.xml
- En páginas de juego y sorteo se incluyen FAQs visibles y schema FAQPage en JSON-LD (inyectado en `<head>` mediante `@stack('head')`)
- Caducidad de premios: se muestra por sorteo (fecha del sorteo + 3 meses) con el cálculo de días restantes
- Fechas en español (Carbon locale configurado)
- Zona horaria: Europe/Madrid

## Licencia

Proyecto privado.
