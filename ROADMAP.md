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

### Contenido
- Mejorar home con contenidos generales (guías, explicación de conceptos y enlaces internos).

### Infra / Deploy
- Revisar que el CLI de RunCloud use siempre PHP 8.2+ (evitar ejecutar artisan con PHP 7.4).
- Migrar el proyecto publicado al dominio `boteshoy.com` y retirar/eliminar el sitio/proyecto anterior.
- Inicializar repositorio Git y publicar en GitHub para control de versiones.

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
