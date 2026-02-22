# Guía de Maquetación para BotesHoy

Esta guía documenta los estilos, componentes y convenciones disponibles para maquetar contenido en el CMS.

## Framework CSS

**Tailwind CSS** vía CDN con colores custom:

### Colores por Juego

| Juego | Clase BG | Clase Border | Clase Text |
|-------|----------|--------------|------------|
| Euromillones | `bg-euro-500` / `bg-euro-600` | `border-euro-500` | `text-euro-500` |
| Bonoloto | `bg-bono-500` / `bg-bono-600` | `border-bono-500` | `text-bono-500` |
| La Primitiva | `bg-primi-500` / `bg-primi-600` | `border-primi-500` | `text-primi-500` |
| El Gordo | `bg-gordo-500` / `bg-gordo-600` | `border-gordo-500` | `text-gordo-500` |

### Colores Tailwind Estándar Disponibles

- Grises: `slate-50` a `slate-900`
- Azules: `blue-50` a `blue-900`
- Rojos: `red-50` a `red-900`
- Verdes: `green-50` a `green-900`, `emerald-50` a `emerald-900`
- Amarillos: `yellow-50` a `yellow-900`, `amber-50` a `amber-900`
- Morados: `purple-50` a `purple-900`, `violet-50` a `violet-900`

---

## Componentes HTML Reutilizables

### 1. Caja de Información (Info Box)

```html
<div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
    <p class="text-blue-800">
        <strong>Información:</strong> Texto explicativo aquí.
    </p>
</div>
```

**Variantes:**
- Advertencia: `bg-amber-50 border-amber-500 text-amber-900`
- Error: `bg-red-50 border-red-500 text-red-800`
- Éxito: `bg-green-50 border-green-500 text-green-800`

### 2. Tabla de Datos

```html
<div class="overflow-x-auto mb-6">
    <table class="min-w-full bg-white border border-slate-200">
        <thead class="bg-euro-500 text-white">
            <tr>
                <th class="px-4 py-2 text-left">Columna 1</th>
                <th class="px-4 py-2 text-center">Columna 2</th>
                <th class="px-4 py-2 text-right">Columna 3</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            <tr class="border-t border-slate-200">
                <td class="px-4 py-2 font-medium">Dato 1</td>
                <td class="px-4 py-2 text-center">Dato 2</td>
                <td class="px-4 py-2 text-right font-semibold">Dato 3</td>
            </tr>
        </tbody>
    </table>
</div>
```

### 3. Grid de Comparación (2 columnas)

```html
<div class="grid md:grid-cols-2 gap-4 mb-6">
    <div class="bg-slate-50 p-4 rounded-lg">
        <h4 class="font-semibold text-slate-800 mb-2">Opción A</h4>
        <ul class="text-sm text-slate-600 space-y-1">
            <li>• Punto 1</li>
            <li>• Punto 2</li>
        </ul>
    </div>
    <div class="bg-euro-500/10 p-4 rounded-lg border-l-4 border-euro-500">
        <h4 class="font-semibold text-slate-800 mb-2">Opción B (destacada)</h4>
        <ul class="text-sm text-slate-600 space-y-1">
            <li>• Punto 1</li>
            <li>• Punto 2</li>
        </ul>
    </div>
</div>
```

### 4. Lista con Iconos

```html
<div class="space-y-3 mb-6">
    <div class="flex items-start gap-3">
        <span class="text-2xl">✅</span>
        <div>
            <h4 class="font-semibold text-slate-800">Título</h4>
            <p class="text-sm text-slate-600">Descripción del punto.</p>
        </div>
    </div>
    <div class="flex items-start gap-3">
        <span class="text-2xl">🎯</span>
        <div>
            <h4 class="font-semibold text-slate-800">Otro título</h4>
            <p class="text-sm text-slate-600">Otra descripción.</p>
        </div>
    </div>
</div>
```

### 5. Sección con Fondo

```html
<section class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Título de Sección</h2>
    <p class="text-slate-700">Contenido aquí...</p>
</section>
```

### 6. Tarjeta de Enlace

```html
<a href="/ruta" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow block">
    <h3 class="font-bold text-slate-800 mb-1">📊 Título</h3>
    <p class="text-sm text-slate-600">Descripción breve</p>
</a>
```

### 7. Tarjeta de Enlace Destacada (con color)

```html
<a href="/ruta" class="bg-euro-500 text-white p-4 rounded-lg hover:opacity-90 transition-opacity block">
    <h3 class="font-bold mb-1">🏆 Título</h3>
    <p class="text-sm text-white/90">Descripción breve</p>
</a>
```

---

## Encabezados

```html
<h2 class="text-xl font-bold text-slate-800 mb-4">H2 - Sección Principal</h2>
<h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">H3 - Subsección</h3>
<h4 class="font-semibold text-slate-800 mb-2">H4 - Punto menor</h4>
```

---

## Listas

### Lista ordenada
```html
<ol class="list-decimal list-inside space-y-2 text-slate-700 mb-6">
    <li>Primer paso</li>
    <li>Segundo paso</li>
    <li>Tercer paso</li>
</ol>
```

### Lista no ordenada
```html
<ul class="text-sm text-slate-600 space-y-1">
    <li>• Punto uno</li>
    <li>• Punto dos</li>
</ul>
```

---

## Schemas JSON-LD

El campo **Head Extra** del CMS permite inyectar schemas directamente en el `<head>`.

### Schema FAQ

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "¿Pregunta 1?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Respuesta 1."
      }
    },
    {
      "@type": "Question",
      "name": "¿Pregunta 2?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Respuesta 2."
      }
    }
  ]
}
</script>
```

### Schema HowTo

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "Cómo hacer X",
  "description": "Guía paso a paso para hacer X",
  "step": [
    {
      "@type": "HowToStep",
      "name": "Paso 1",
      "text": "Descripción del paso 1"
    },
    {
      "@type": "HowToStep",
      "name": "Paso 2",
      "text": "Descripción del paso 2"
    }
  ]
}
</script>
```

### Schema Article

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Título del artículo",
  "description": "Descripción breve",
  "author": {
    "@type": "Organization",
    "name": "BotesHoy"
  },
  "publisher": {
    "@type": "Organization",
    "name": "BotesHoy",
    "url": "https://boteshoy.com"
  },
  "datePublished": "2026-02-22",
  "dateModified": "2026-02-22"
}
</script>
```

---

## Emojis Recomendados

| Uso | Emoji |
|-----|-------|
| Éxito/Ventaja | ✅ |
| Objetivo/Precisión | 🎯 |
| Dinero/Coste | 💰 |
| Premio/Trofeo | 🏆 |
| Información | ℹ️ |
| Advertencia | ⚠️ |
| Estadísticas | 📊 |
| Guía/Libro | 📖 |
| Calendario | 📅 |
| Estrella | ⭐ |

---

## Estructura de Vistas

Las vistas que soportan contenido CMS:
- `juego-apuestas-multiples.blade.php`
- `juego-apuestas-reducidas.blade.php`
- `juego-combinacion-ganadora.blade.php`

Cada una tiene:
- `@section('title')` - Título SEO
- `@section('description')` - Meta description
- `@push('head')` - Para head_extra (schemas, meta tags)
- Contenido HTML editable desde CMS

---

## Campos del CMS

| Campo | Descripción | Límite |
|-------|-------------|--------|
| SEO Title | Título para `<title>` | 60 chars |
| Meta Description | Meta description | 160 chars |
| H1 Principal | Encabezado principal | 100 chars |
| Contenido HTML | Cuerpo del artículo | Sin límite |
| Head Extra | Schemas JSON-LD, meta tags | Sin límite |
| OG Title | Título para redes sociales | 60 chars |
| OG Description | Descripción para redes | 160 chars |
| OG Image | URL de imagen para redes | URL |
