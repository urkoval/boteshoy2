# Boteshoy.com - Documento de Requisitos

## 1. Visión del Proyecto

Web de resultados de loterías españolas. Objetivo: posicionar en búsquedas de tendencia ("resultados bonoloto hoy", "euromillones último sorteo") y monetizar con ads (Adsense/Adsterra).

**Público objetivo:** General, muchos usuarios mayores con móvil. No freaks estadísticos.

**Principios:** Carga rápida, mobile-first, contenido autogenerado, mínimo mantenimiento manual.

---

## 2. MVP - Alcance Funcional

### 2.1 Juegos incluidos
- Euromillones
- Bonoloto
- La Primitiva
- El Gordo de la Primitiva

### 2.2 Páginas

| Ruta | Contenido | Intención de Búsqueda |
|------|-----------|----------------------|
| `/` | Home con últimos resultados de todos los juegos | Consulta multi-juego |
| `/{juego}/` | Último resultado + listado histórico paginado | Consulta resultados |
| `/{juego}/{fecha}/` | Resultado específico (ej: `/bonoloto/2025-01-17/`) | Consulta sorteo específico |
| `/{juego}/guia` | Guía completa del juego (cómo jugar, reglas, premios) | Aprender a jugar |

### 2.3 Datos por sorteo
- Fecha del sorteo
- Números ganadores
- Estrellas / Complementario / Reintegro (según juego)
- Bote
- Tabla de premios (categoría, acertantes, premio)
- Localidades premiadas (básico o placeholder si no disponible)

### 2.4 Funcionalidades
- Autogeneración de páginas al recibir nuevos datos
- SEO básico: títulos dinámicos, meta descriptions, URLs limpias
- Diseño responsive mobile-first
- Sitemap XML autogenerado

---

## 3. Stack Técnico

### 3.1 Backend
- **Framework:** Laravel 11
- **PHP:** 8.2+
- **Base de datos:** MySQL
- **Hosting:** RunCloud (servidor existente)

### 3.2 Frontend
- **Plantillas:** Blade
- **CSS:** Tailwind CSS
- **JS:** Mínimo, vanilla si es necesario

### 3.3 Scraping
- **Lenguaje:** Python 3
- **Fuente:** Lotoluck (principal), otras webs como backup
- **Ejecución:** Cron jobs tras cada sorteo

### 3.4 Repositorio
- GitHub
- Desarrollo con Windsurf

---

## 4. Modelo de Datos

### 4.1 Tabla `juegos`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | int | PK |
| slug | varchar | ej: "bonoloto" |
| nombre | varchar | ej: "Bonoloto" |
| dias_sorteo | varchar | ej: "lunes,martes,miércoles,jueves,viernes,sábado" |

### 4.2 Tabla `sorteos`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | int | PK |
| juego_id | int | FK → juegos |
| fecha | date | Fecha del sorteo |
| numeros | json | Array de números ganadores |
| complementarios | json | Estrellas, complementario, reintegro según juego |
| bote | decimal | Bote en euros |
| premios | json | Array de categorías con acertantes y premio |
| localidades | json | Info de dónde tocó (nullable) |
| created_at | timestamp | |
| updated_at | timestamp | |

**Índices:** `juego_id + fecha` (único)

---

## 5. Frecuencia de Sorteos

| Juego | Días | Hora aprox. |
|-------|------|-------------|
| Euromillones | Martes, Viernes | 21:30 |
| Bonoloto | Lunes a Sábado | 21:30 |
| La Primitiva | Jueves, Sábado | 21:30 |
| El Gordo | Domingo | 21:30 |

**Cron sugerido:** Ejecutar scraping a las 22:00 y 23:00 los días de sorteo.

---

## 6. SEO

**PRINCIPIO FUNDAMENTAL:** Cada página debe responder a UNA ÚNICA intención de búsqueda. Este principio debe guiar todas las decisiones de desarrollo y estructura de contenido. Una página no puede rankear bien para dos intenciones diferentes.

### 6.1 Títulos (ejemplos)
- Home: "Resultados Loterías España Hoy | Boteshoy"
- Juego (resultados): "Resultados Bonoloto Hoy | Último Sorteo y Premios"
- Sorteo: "Resultado Bonoloto 17 enero 2025 | Números y Premios"
- Guía: "Cómo se juega a Bonoloto | Guía Completa 2026”

### 6.2 URLs
- Limpias, sin IDs
- Fechas en formato `YYYY-MM-DD`
- Slugs en minúsculas sin tildes

### 6.3 Sitemap
- Autogenerado con todas las URLs de sorteos
- Actualizado tras cada scraping

### 6.4 Mapeo de URLs e Intenciones de Búsqueda

Cada URL debe tener claramente definida su intención de búsqueda principal y el tipo de contenido que ofrece.

| URL | Intención de Búsqueda | Finalidad | Contenido Principal |
|-----|----------------------|-----------|---------------------|
| `/` | "resultados loterías hoy" | Consulta rápida multi-juego | Últimos resultados de todos los juegos + botes destacados |
| `/{juego}/` | "resultados {juego} hoy" | Consulta resultados específicos | Último resultado destacado + histórico paginado |
| `/{juego}/{fecha}/` | "resultado {juego} {fecha}" | Consulta resultado específico | Números ganadores, premios, localidades del sorteo |
| `/{juego}/guia` | "cómo se juega {juego}" | Hub completo informativo | Reglas básicas, conceptos, premios, probabilidades, horarios, FAQs |
| `/{juego}/apuestas-multiples` | "apuestas múltiples {juego}" | Info jugadas avanzadas | Qué son, costes, tabla de combinaciones, ventajas, ejemplos |
| `/{juego}/apuestas-reducidas` | "apuestas reducidas {juego}" | Sistemas optimizados | Concepto, garantías, comparación, dónde hacerlas |
| `/{juego}/combinacion-ganadora` | "combinación ganadora {juego}" | Comprobar boleto | Qué es, cómo comprobar, dónde ver, qué hacer si ganas |

**Criterios de separación:**
- **Consultar datos:** → Páginas de resultados (mostrar números, premios, fechas)
- **Aprender/Informarse:** → Páginas de guía (explicar reglas, conceptos, cómo jugar)
- **Comparar/Elegir:** → Contenido general (futuro: comparativas entre juegos)

---

## 7. Fases del Proyecto

### Fase 1: MVP (actual)
- [ ] Estructura Laravel
- [ ] Modelo de datos
- [ ] Script scraping Python (4 juegos)
- [ ] Cron de scraping
- [ ] Plantillas Blade (home, juego, sorteo)
- [ ] Estilos Tailwind básicos
- [ ] Deploy en RunCloud
- [ ] Dominio apuntando

### Fase 2: Consolidación
- [ ] Resto de juegos SELAE
- [ ] Mejora de info localidades/repartos
- [ ] Estadísticas básicas (números más frecuentes)
- [ ] Optimización de velocidad

### Fase 3: Expansión
- [ ] ONCE
- [ ] Otras loterías
- [ ] Notificaciones / alertas
- [ ] Funcionalidades según demanda

---

## 8. Referencias

**Competencia:**
- https://www.laprimitiva.info/
- https://www.loteriabonoloto.info/

**Fuente de datos:**
- Lotoluck (principal)

---

## 9. Notas

- Tiempo disponible: ~4h semanales
- Prioridad: que funcione y se automantenga
- No sobreingeniería: resolver problemas cuando aparezcan