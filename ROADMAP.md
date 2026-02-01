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
- Mejorar diseño del favicon para mejor legibilidad en pestañas de Chrome.

### Contenido
- Mejorar home con contenidos generales (guías, explicación de conceptos y enlaces internos).

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

- Páginas de guía (cómo jugar, probabilidades, qué es reintegro/estrellas/número clave).
- Alertas/monitoring: detectar cuando no se actualiza la fuente.
