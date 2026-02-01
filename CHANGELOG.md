# Changelog

Formato inspirado en "Keep a Changelog".

## [Unreleased]

## [2026-01-30]
### Added
- FAQs visibles y schema `FAQPage` en JSON-LD en páginas de juego y sorteo.
- Caducidad de premios por sorteo (fecha del sorteo + 3 meses) mostrando días restantes.
- `@stack('head')` en el layout para permitir inyección de JSON-LD desde vistas.

### Fixed
- Render incorrecto de `title`/`description` en Blade cuando se usaban secciones inline con contenido dinámico.

### Docs
- Añadido `view:clear` en la sección de limpieza de caché para RunCloud con PHP 8.2.
