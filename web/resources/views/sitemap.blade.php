<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    @foreach($juegos as $juego)
    <url>
        <loc>{{ route('juego', $juego->slug) }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    
    @foreach($sorteos as $sorteo)
    <url>
        <loc>{{ route('sorteo', [$sorteo->juego->slug, $sorteo->fecha->format('Y-m-d')]) }}</loc>
        <lastmod>{{ $sorteo->updated_at->toIso8601String() }}</lastmod>
        <changefreq>never</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
