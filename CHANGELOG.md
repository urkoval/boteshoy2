# Changelog

Formato inspirado en "Keep a Changelog".

## [Unreleased]

## [2026-02-01]
### Infra / Deploy
- Repositorio GitHub privado `urkoval/boteshoy2` creado y sincronizado.
- Deploy en producción vía `git pull` desde GitHub.
- Dominio `boteshoy.com` migrado al nuevo servidor (IP: 135.181.152.169).
- SSL Let's Encrypt configurado en RunCloud.
- Proyecto anterior retirado (solo queda backup).
- CLI de RunCloud configurado para usar PHP 8.2 (`/usr/local/lsws/lsphp82/bin/php`).

### SEO
- Configuradas redirecciones 301 desde URLs antiguas (`/lottery/*`, `/about`) a nuevas URLs del site.
- Redirecciones implementadas en `.htaccess` a nivel de webserver.
- Mejorados encabezados SEO en páginas de juego: H1 descriptivo “Últimos resultados de [Juego]” y H2 “Historial de sorteos”.

### Added
- FAQs visibles y schema `FAQPage` en JSON-LD en páginas de juego y sorteo.
- Caducidad de premios por sorteo (fecha del sorteo + 3 meses) mostrando días restantes.
- `@stack('head')` en el layout para permitir inyección de JSON-LD desde vistas.

### Fixed
- Render incorrecto de `title`/`description` en Blade cuando se usaban secciones inline con contenido dinámico.

### Docs
- Añadido `view:clear` en la sección de limpieza de caché para RunCloud con PHP 8.2.
