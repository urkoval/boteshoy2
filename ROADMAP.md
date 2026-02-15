# Roadmap

Documento de planificación a alto nivel. Ajustar según necesidades.

## Now (próximo)
### Juegos (pendientes)
- Eurodreams.
- Lotería Nacional.
- Lotería Nacional de Jueves.
- Lotería de Navidad.
- Lotería del Niño.

### SEO
- Canonical por página.
- BreadcrumbList (schema) en página de sorteo.
- OpenGraph/Twitter cards.
- ~~Redirecciones 301 desde URLs antiguas (/lottery/*, /about)~~ ✅ **Hecho (2026-02-01)**
- ~~Encabezados SEO en páginas de juego (H1/H2 descriptivos)~~ ✅ **Hecho (2026-02-01)**
- ~~Favicon y manifest añadidos~~ ✅ **Hecho (2026-02-01)**
- ~~Google Analytics integrado~~ ✅ **Hecho (2026-02-01)**
- ~~Columna Aciertos añadida en tablas de premios (Bonoloto, La Primitiva, El Gordo)~~ ✅ **Hecho (2026-02-07)**
- Mejorar diseño del favicon para mejor legibilidad en pestañas de Chrome.

### Contenido
- Mejorar home con contenidos generales (guías, explicación de conceptos y enlaces internos).

### Errores a corregir
- ~~Tabla de premios de Euromillones muestra cantidades incorrectas~~ ✅ **Resuelto (2026-02-03)**
- ~~Scraping de El Gordo intercambia columnas (aciertos ↔ acertantes, acertantes ↔ premios)~~ ✅ **Resuelto (2026-02-09)**
- Nota: Sorteo del 27/01/2026 falló en actualización, dejar pendiente para revisión manual.

### Infra / Deploy
- ~~Revisar que el CLI de RunCloud use siempre PHP 8.2+ (evitar ejecutar artisan con PHP 7.4)~~ ✅ **Hecho (2026-02-01)**
- ~~Migrar el proyecto publicado al dominio `boteshoy.com`~~ ✅ **Hecho (2026-02-01)**
- ~~Inicializar repositorio Git y publicar en GitHub~~ ✅ **Hecho (2026-02-01)**

## Next
### Juegos (pendientes)
- Quiniela.
- Quinigol.

### Datos / DB
- Mantener SQLite mientras el tráfico sea bajo/medio y no haya problemas de locks.
- Si crece el tráfico o se requiere escalado: plan de migración a MariaDB (cambio de `DB_CONNECTION` en Laravel + migración de datos + adaptar scraper Python, que hoy escribe directo en SQLite).

### SEO
- Revisar titles/descriptions para cubrir long tails adicionales por juego sin duplicación.
- Mejorar interlinking (home -> juegos -> sorteos) y anchors.

### Datos
- Reforzar crons de botes y sorteos: reintentos, registro de logs y verificación/monitorización básica.
- Revisar navegación e indexación del histórico: paginación, enlazado interno y relevancia de sorteos caducados (sin eliminar URLs).

## Later
### Juegos (pendientes)
- Quíntuple Plus.
- Lototurf.

### Contenido SEO (propuestas)
- **Artículos de long-tail por juego:**
  - "Números más frecuentes Euromillones 2025"
  - "Cómo ganar en Bonoloto: estadísticas y consejos"
  - "Historial de premios La Primitiva últimos 5 años"
  - "El Gordo de la Primitiva: números clave históricos"
- **Guías completas:**
  - "Guía completa de loterías españolas 2025"
  - "Cómo reclamar premios de lotería paso a paso"
  - "Impuestos en premios de lotería: todo lo que necesitas saber"
  - "Caducidad de premios: fechas y plazos por juego"
- **Contenido estadístico:**
  - "Análisis de frecuencia de números por sorteo"
  - "Combinaciones menos probables en Euromillones"
  - "Estadísticas históricas de botes acumulados"
  - "Patrones de sorteo por día de la semana"
- **Comparativas y rankings:**
  - "Qué lotería tiene mejores probabilidades de ganar"
  - "Comparación de costes vs premios por juego"
  - "Ranking de botes más grandes de la historia"
  - "Loterías más rentables según estadísticas"

- Páginas de guía (cómo jugar, probabilidades, qué es reintegro/estrellas/número clave).
- Alertas/monitoring: detectar cuando no se actualiza la fuente.
