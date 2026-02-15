<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Juego;
use App\Models\ContenidoJuego;

class ContenidoJuegoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los juegos
        $juegos = Juego::all();
        
        foreach ($juegos as $juego) {
            // Crear contenido para apuestas múltiples
            $this->crearApuestasMultiples($juego);
            
            // Crear contenido para apuestas reducidas
            $this->crearApuestasReducidas($juego);
            
            // Crear contenido para combinación ganadora
            $this->crearCombinacionGanadora($juego);
        }
    }
    
    private function crearApuestasMultiples(Juego $juego): void
    {
        $contenido = [
            'euromillones' => [
                'seo_title' => 'Apuestas Múltiples en Euromillones | 5 Números + Estrellas',
                'meta_description' => 'Aprende cómo hacer apuestas múltiples en Euromillones: 5 números (1-50) + 2 estrellas (1-12), costes, combinaciones y ejemplos prácticos.',
                'h1_principal' => 'Apuestas Múltiples en Euromillones',
                'contenido_html' => $this->getHtmlEuromillonesMultiples(),
                'datos_especificos' => [
                    'coste_base' => 2.50,
                    'numeros_principales' => 5,
                    'estrellas' => 2,
                    'rango_numeros' => [1, 50],
                    'rango_estrellas' => [1, 12],
                    'tabla_combinaciones' => [
                        ['numeros' => 6, 'estrellas' => 2, 'combinaciones' => 6, 'coste' => 15.00],
                        ['numeros' => 7, 'estrellas' => 2, 'combinaciones' => 21, 'coste' => 52.50],
                        ['numeros' => 8, 'estrellas' => 2, 'combinaciones' => 56, 'coste' => 140.00],
                        ['numeros' => 5, 'estrellas' => 3, 'combinaciones' => 3, 'coste' => 7.50],
                        ['numeros' => 5, 'estrellas' => 4, 'combinaciones' => 6, 'coste' => 15.00],
                    ]
                ]
            ],
            'bonoloto' => [
                'seo_title' => 'Apuestas Múltiples en Bonoloto | 6 Números (1-49)',
                'meta_description' => 'Descubre cómo funcionan las apuestas múltiples en Bonoloto: juega más de 6 números, tabla de costes y combinaciones. La forma más económica de jugar múltiple.',
                'h1_principal' => 'Apuestas Múltiples en Bonoloto',
                'contenido_html' => $this->getHtmlBonolotoMultiples(),
                'datos_especificos' => [
                    'coste_base' => 0.50,
                    'numeros_principales' => 6,
                    'rango_numeros' => [1, 49],
                    'tabla_combinaciones' => [
                        ['numeros' => 7, 'combinaciones' => 7, 'coste' => 3.50],
                        ['numeros' => 8, 'combinaciones' => 28, 'coste' => 14.00],
                        ['numeros' => 9, 'combinaciones' => 84, 'coste' => 42.00],
                        ['numeros' => 10, 'combinaciones' => 210, 'coste' => 105.00],
                    ]
                ]
            ],
            'la-primitiva' => [
                'seo_title' => 'Apuestas Múltiples en La Primitiva | 6 Números + Reintegro',
                'meta_description' => 'Aprende a hacer apuestas múltiples en La Primitiva: 6 números (1-49) + reintegro, costes, combinaciones y cómo funciona el reintegro en múltiples.',
                'h1_principal' => 'Apuestas Múltiples en La Primitiva',
                'contenido_html' => $this->getHtmlPrimitivaMultiples(),
                'datos_especificos' => [
                    'coste_base' => 1.00,
                    'numeros_principales' => 6,
                    'rango_numeros' => [1, 49],
                    'tiene_reintegro' => true,
                    'tabla_combinaciones' => [
                        ['numeros' => 7, 'combinaciones' => 7, 'coste' => 7.00],
                        ['numeros' => 8, 'combinaciones' => 28, 'coste' => 28.00],
                        ['numeros' => 9, 'combinaciones' => 84, 'coste' => 84.00],
                        ['numeros' => 10, 'combinaciones' => 210, 'coste' => 210.00],
                    ]
                ]
            ],
            'el-gordo' => [
                'seo_title' => 'Apuestas Múltiples en El Gordo | 6 Números + Reintegro Semanal',
                'meta_description' => 'Cómo hacer apuestas múltiples en El Gordo de la Primitiva: 6 números (1-49) + reintegro, costes y bote especial semanal.',
                'h1_principal' => 'Apuestas Múltiples en El Gordo',
                'contenido_html' => $this->getHtmlGordoMultiples(),
                'datos_especificos' => [
                    'coste_base' => 1.50,
                    'numeros_principales' => 6,
                    'rango_numeros' => [1, 49],
                    'tiene_reintegro' => true,
                    'bote_minimo' => 5000000,
                    'tabla_combinaciones' => [
                        ['numeros' => 7, 'combinaciones' => 7, 'coste' => 10.50],
                        ['numeros' => 8, 'combinaciones' => 28, 'coste' => 42.00],
                        ['numeros' => 9, 'combinaciones' => 84, 'coste' => 126.00],
                        ['numeros' => 10, 'combinaciones' => 210, 'coste' => 315.00],
                    ]
                ]
            ]
        ];
        
        if (isset($contenido[$juego->slug])) {
            ContenidoJuego::create([
                'juego_id' => $juego->id,
                'tipo_contenido' => 'apuestas_multiples',
                'seo_title' => $contenido[$juego->slug]['seo_title'],
                'meta_description' => $contenido[$juego->slug]['meta_description'],
                'h1_principal' => $contenido[$juego->slug]['h1_principal'],
                'contenido_html' => $contenido[$juego->slug]['contenido_html'],
                'datos_especificos' => $contenido[$juego->slug]['datos_especificos'],
                'activo' => true,
            ]);
        }
    }
    
    private function crearApuestasReducidas(Juego $juego): void
    {
        $contenido = [
            'euromillones' => [
                'seo_title' => 'Apuestas Reducidas en Euromillones | Sistemas Optimizados',
                'meta_description' => 'Descubre las apuestas reducidas en Euromillones: sistemas optimizados para jugar más números y estrellas con menor coste, garantías y ejemplos.',
                'h1_principal' => 'Apuestas Reducidas en Euromillones',
                'contenido_html' => $this->getHtmlEuromillonesReducidas(),
            ],
            'bonoloto' => [
                'seo_title' => 'Apuestas Reducidas en Bonoloto | Sistemas Baratos',
                'meta_description' => 'Aprende sobre apuestas reducidas en Bonoloto: sistemas económicos para jugar más números con garantías de acierto y menor coste.',
                'h1_principal' => 'Apuestas Reducidas en Bonoloto',
                'contenido_html' => $this->getHtmlBonolotoReducidas(),
            ],
            'la-primitiva' => [
                'seo_title' => 'Apuestas Reducidas en La Primitiva | Sistemas con Reintegro',
                'meta_description' => 'Cómo funcionan las apuestas reducidas en La Primitiva: sistemas optimizados con reintegro, garantías y costes reducidos.',
                'h1_principal' => 'Apuestas Reducidas en La Primitiva',
                'contenido_html' => $this->getHtmlPrimitivaReducidas(),
            ],
            'el-gordo' => [
                'seo_title' => 'Apuestas Reducidas en El Gordo | Sistemas Semanales',
                'meta_description' => 'Apuestas reducidas en El Gordo: sistemas optimizados para el sorteo semanal con bote especial y garantías de premio.',
                'h1_principal' => 'Apuestas Reducidas en El Gordo',
                'contenido_html' => $this->getHtmlGordoReducidas(),
            ]
        ];
        
        if (isset($contenido[$juego->slug])) {
            ContenidoJuego::create([
                'juego_id' => $juego->id,
                'tipo_contenido' => 'apuestas_reducidas',
                'seo_title' => $contenido[$juego->slug]['seo_title'],
                'meta_description' => $contenido[$juego->slug]['meta_description'],
                'h1_principal' => $contenido[$juego->slug]['h1_principal'],
                'contenido_html' => $contenido[$juego->slug]['contenido_html'],
                'activo' => true,
            ]);
        }
    }
    
    private function crearCombinacionGanadora(Juego $juego): void
    {
        $contenido = [
            'euromillones' => [
                'seo_title' => 'Combinación Ganadora Euromillones | 5 Números + 2 Estrellas',
                'meta_description' => 'Cómo comprobar la combinación ganadora de Euromillones: 5 números + 2 estrellas, 13 categorías de premios y qué hacer si ganas.',
                'h1_principal' => 'Combinación Ganadora Euromillones',
                'contenido_html' => $this->getHtmlEuromillonesCombinacion(),
            ],
            'bonoloto' => [
                'seo_title' => 'Combinación Ganadora Bonoloto | 6 Números del 1 al 49',
                'meta_description' => 'Aprende a comprobar la combinación ganadora de Bonoloto: 6 números, categorías de premios, dónde verificar y cómo cobrar.',
                'h1_principal' => 'Combinación Ganadora Bonoloto',
                'contenido_html' => $this->getHtmlBonolotoCombinacion(),
            ],
            'la-primitiva' => [
                'seo_title' => 'Combinación Ganadora La Primitiva | 6 Números + Complementario + Reintegro',
                'meta_description' => 'Cómo saber la combinación ganadora de La Primitiva: 6 números + complementario + reintegro, categorías y dónde cobrar premios.',
                'h1_principal' => 'Combinación Ganadora La Primitiva',
                'contenido_html' => $this->getHtmlPrimitivaCombinacion(),
            ],
            'el-gordo' => [
                'seo_title' => 'Combinación Ganadora El Gordo | 6 Números + Reintegro Semanal',
                'meta_description' => 'Comprobar la combinación ganadora de El Gordo: 6 números + reintegro, bote especial semanal y cómo verificar tu boleto.',
                'h1_principal' => 'Combinación Ganadora El Gordo',
                'contenido_html' => $this->getHtmlGordoCombinacion(),
            ]
        ];
        
        if (isset($contenido[$juego->slug])) {
            ContenidoJuego::create([
                'juego_id' => $juego->id,
                'tipo_contenido' => 'combinacion_ganadora',
                'seo_title' => $contenido[$juego->slug]['seo_title'],
                'meta_description' => $contenido[$juego->slug]['meta_description'],
                'h1_principal' => $contenido[$juego->slug]['h1_principal'],
                'contenido_html' => $contenido[$juego->slug]['contenido_html'],
                'activo' => true,
            ]);
        }
    }
    
    // Métodos para generar HTML específico
    private function getHtmlEuromillonesMultiples(): string
    {
        return '<h2>¿Qué son las Apuestas Múltiples en Euromillones?</h2>
<p>En Euromillones, las apuestas múltiples te permiten seleccionar más de 5 números y más de 2 estrellas en un mismo boleto, generando automáticamente todas las combinaciones posibles.</p>
<h3>¿Cómo funcionan?</h3>
<p>Euromillones tiene una mecánica única: seleccionas 5 números de 1-50 y 2 estrellas de 1-12. En múltiple, puedes elegir hasta 10 números y hasta 12 estrellas.</p>
<h3>Tabla de Apuestas Múltiples Euromillones</h3>
<table class="w-full border-collapse border border-gray-300">
<thead><tr class="bg-gray-100">
<th class="border border-gray-300 px-4 py-2 text-left">Números</th>
<th class="border border-gray-300 px-4 py-2 text-left">Estrellas</th>
<th class="border border-gray-300 px-4 py-2 text-left">Combinaciones</th>
<th class="border border-gray-300 px-4 py-2 text-right">Coste</th>
</tr></thead>
<tbody>
<tr><td class="border border-gray-300 px-4 py-2">6</td><td class="border border-gray-300 px-4 py-2">2</td><td class="border border-gray-300 px-4 py-2">6</td><td class="border border-gray-300 px-4 py-2 text-right">15,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2">2</td><td class="border border-gray-300 px-4 py-2">21</td><td class="border border-gray-300 px-4 py-2 text-right">52,50€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">8</td><td class="border border-gray-300 px-4 py-2">2</td><td class="border border-gray-300 px-4 py-2">56</td><td class="border border-gray-300 px-4 py-2 text-right">140,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">5</td><td class="border border-gray-300 px-4 py-2">3</td><td class="border border-gray-300 px-4 py-2">3</td><td class="border border-gray-300 px-4 py-2 text-right">7,50€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">5</td><td class="border border-gray-300 px-4 py-2">4</td><td class="border border-gray-300 px-4 py-2">6</td><td class="border border-gray-300 px-4 py-2 text-right">15,00€</td></tr>
</tbody></table>
<h3>Ventajas de Jugar Múltiple en Euromillones</h3>
<ul><li><strong>Mayor cobertura:</strong> Más números y estrellas = más posibilidades de acertar</li><li><strong>Estrategia:</strong> Puedes jugar tus números favoritos juntos</li><li><strong>Comodidad:</strong> Una sola apuesta cubre múltiples combinaciones</li></ul>
<div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-6">
<p class="text-blue-800"><strong>Consejo:</strong> Las apuestas múltiples con más estrellas suelen ser más rentables que aumentar los números principales.</p>
</div>';
    }
    
    private function getHtmlBonolotoMultiples(): string
    {
        return '<h2>¿Qué son las Apuestas Múltiples en Bonoloto?</h2>
<p>Las apuestas múltiples en Bonoloto te permiten seleccionar más de 6 números en un mismo boleto, generando todas las combinaciones posibles de 6 números.</p>
<h3>Ventaja Principal de Bonoloto</h3>
<p>Bonoloto es el juego más económico para hacer apuestas múltiples: solo 0,50€ por combinación, frente a 1€ de Primitiva o 2,50€ de Euromillones.</p>
<h3>Tabla de Apuestas Múltiples Bonoloto</h3>
<table class="w-full border-collapse border border-gray-300">
<thead><tr class="bg-gray-100">
<th class="border border-gray-300 px-4 py-2 text-left">Números</th>
<th class="border border-gray-300 px-4 py-2 text-left">Combinaciones</th>
<th class="border border-gray-300 px-4 py-2 text-right">Coste</th>
</tr></thead>
<tbody>
<tr><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2 text-right">3,50€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">8</td><td class="border border-gray-300 px-4 py-2">28</td><td class="border border-gray-300 px-4 py-2 text-right">14,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">9</td><td class="border border-gray-300 px-4 py-2">84</td><td class="border border-gray-300 px-4 py-2 text-right">42,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">10</td><td class="border border-gray-300 px-4 py-2">210</td><td class="border border-gray-300 px-4 py-2 text-right">105,00€</td></tr>
</tbody></table>
<h3>¿Cuándo jugar múltiple en Bonoloto?</h3>
<ul><li>Cuando tienes varios números favoritos</li><li>Quieres maximizar posibilidades con presupuesto limitado</li><li>Para jugar sistemáticamente sin gastar demasiado</li></ul>';
    }
    
    private function getHtmlPrimitivaMultiples(): string
    {
        return '<h2>¿Qué son las Apuestas Múltiples en La Primitiva?</h2>
<p>En La Primitiva, las apuestas múltiples te permiten seleccionar más de 6 números, generando todas las combinaciones posibles con reintegro automático.</p>
<h3>¿Cómo funciona el Reintegro en Múltiples?</h3>
<p>En apuestas múltiples de La Primitiva, el reintegro (0-9) se asigna automáticamente a cada combinación generada. No puedes elegir el reintegro en múltiple.</p>
<h3>Tabla de Apuestas Múltiples La Primitiva</h3>
<table class="w-full border-collapse border border-gray-300">
<thead><tr class="bg-gray-100">
<th class="border border-gray-300 px-4 py-2 text-left">Números</th>
<th class="border border-gray-300 px-4 py-2 text-left">Combinaciones</th>
<th class="border border-gray-300 px-4 py-2 text-right">Coste</th>
</tr></thead>
<tbody>
<tr><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2 text-right">7,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">8</td><td class="border border-gray-300 px-4 py-2">28</td><td class="border border-gray-300 px-4 py-2 text-right">28,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">9</td><td class="border border-gray-300 px-4 py-2">84</td><td class="border border-gray-300 px-4 py-2 text-right">84,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">10</td><td class="border border-gray-300 px-4 py-2">210</td><td class="border border-gray-300 px-4 py-2 text-right">210,00€</td></tr>
</tbody></table>
<h3>Características Especiales</h3>
<ul><li><strong>Reintegro automático:</strong> Cada combinación tiene su propio reintegro</li><li><strong>Joker:</strong> Puedes añadirlo a cada combinación por 1€ adicional</li><li><strong>Complementario:</strong> Mayor probabilidad de acertar 5+complementario</li></ul>';
    }
    
    private function getHtmlGordoMultiples(): string
    {
        return '<h2>¿Qué son las Apuestas Múltiples en El Gordo?</h2>
<p>El Gordo de la Primitiva funciona igual que La Primitiva en apuestas múltiples, pero con la ventaja del bote semanal mínimo de 5 millones de euros.</p>
<h3>Características del Sorteo Semanal</h3>
<p>El Gordo se celebra todos los jueves con un bote mínimo garantizado de 5 millones, lo que lo hace especialmente atractivo para apuestas múltiples.</p>
<h3>Tabla de Apuestas Múltiples El Gordo</h3>
<table class="w-full border-collapse border border-gray-300">
<thead><tr class="bg-gray-100">
<th class="border border-gray-300 px-4 py-2 text-left">Números</th>
<th class="border border-gray-300 px-4 py-2 text-left">Combinaciones</th>
<th class="border border-gray-300 px-4 py-2 text-right">Coste</th>
</tr></thead>
<tbody>
<tr><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2">7</td><td class="border border-gray-300 px-4 py-2 text-right">10,50€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">8</td><td class="border border-gray-300 px-4 py-2">28</td><td class="border border-gray-300 px-4 py-2 text-right">42,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">9</td><td class="border border-gray-300 px-4 py-2">84</td><td class="border border-gray-300 px-4 py-2 text-right">126,00€</td></tr>
<tr><td class="border border-gray-300 px-4 py-2">10</td><td class="border border-gray-300 px-4 py-2">210</td><td class="border border-gray-300 px-4 py-2 text-right">315,00€</td></tr>
</tbody></table>
<h3>Ventaja del Bote Semanal</h3>
<ul><li><strong>Bote garantizado:</strong> Mínimo 5 millones cada jueves</li><li><strong>Menos competencia:</strong> Menos jugadores que Euromillones</li><li><strong>Premios secundarios:</strong> 8 categorías con buenos premios</li></ul>';
    }
    
    // Métodos para contenido reducidas (versiones simplificadas)
    private function getHtmlEuromillonesReducidas(): string
    {
        return '<h2>¿Qué son las Apuestas Reducidas en Euromillones?</h2>
<p>Las apuestas reducidas en Euromillones son sistemas optimizados que te permiten jugar más números y estrellas con un coste reducido, garantizando determinados premios.</p>
<h3>¿Cómo funcionan?</h3>
<p>En lugar de generar todas las combinaciones posibles (como en múltiple), las reducidas usan algoritmos matemáticos para seleccionar solo las combinaciones necesarias.</p>
<h3>Garantías Comunes</h3>
<ul><li><strong>3 si 3:</strong> Garantiza acertar 3 números si aciertas 3</li><li><strong>2+1 si 2+1:</strong> Garantiza 2 números + 1 estrella si aciertas eso</li><li><strong>1+2 si 1+2:</strong> Garantiza 1 número + 2 estrellas si aciertas eso</li></ul>
<div class="bg-amber-50 border-l-4 border-amber-500 p-4 mt-6">
<p class="text-amber-900"><strong>Ventaja principal:</strong> Puedes jugar 8 números + 4 estrellas por menos de 30€ en lugar de los 224€ costaría en múltiple.</p>
</div>';
    }
    
    private function getHtmlBonolotoReducidas(): string
    {
        return '<h2>¿Qué son las Apuestas Reducidas en Bonoloto?</h2>
<p>Las apuestas reducidas en Bonoloto son sistemas matemáticos que permiten jugar más números por menos dinero, con garantías de acierto.</p>
<h3>Ventaja Económica</h3>
<p>Gracias al bajo coste de Bonoloto (0,50€ por combinación), las apuestas reducidas son especialmente económicas.</p>
<h3>Ejemplo Práctico</h3>
<ul><li><strong>Jugar 10 números en múltiple:</strong> 105€</li><li><strong>Jugar 10 números en reducido 3 si 3:</strong> 12-15€</li><li><strong>Ahorro:</strong> Más del 85%</li></ul>
<h3>Garantías Populares</h3>
<ul><li><strong>3 si 3:</strong> Asegura premio de 3 aciertos</li><li><strong>4 si 4:</strong> Asegura premio de 4 aciertos</li><li><strong>5 si 5:</strong> Asegura premio de 5 aciertos</li></ul>';
    }
    
    private function getHtmlPrimitivaReducidas(): string
    {
        return '<h2>¿Qué son las Apuestas Reducidas en La Primitiva?</h2>
<p>Las apuestas reducidas en La Primitiva son sistemas optimizados que permiten jugar más números con menor coste, manteniendo el reintegro automático.</p>
<h3>¿Cómo afecta el reintegro?</h3>
<p>En apuestas reducidas de La Primitiva, el reintegro se asigna automáticamente a cada combinación seleccionada por el sistema.</p>
<h3>Sistemas Más Populares</h3>
<ul><li><strong>8 números 3 si 3:</strong> Unas 8-10 combinaciones</li><li><strong>9 números 4 si 4:</strong> Unas 12-15 combinaciones</li><li><strong>10 números 3 si 3:</strong> Unas 10-12 combinaciones</li></ul>
<h3>Ventaja sobre Múltiple</h3>
<p>Mientras 10 números en múltiple cuestan 210€, en reducido 3 si 3 puedes jugarlos por menos de 15€.</p>';
    }
    
    private function getHtmlGordoReducidas(): string
    {
        return '<h2>¿Qué son las Apuestas Reducidas en El Gordo?</h2>
<p>Las apuestas reducidas en El Gordo funcionan igual que en La Primitiva, pero están optimizadas para el sorteo semanal con bote garantizado.</p>
<h3>Ventaja del Bote Semanal</h3>
<p>El bote mínimo de 5 millones hace que las apuestas reducidas sean especialmente atractivas para maximizar posibilidades de ganar el gran premio.</p>
<h3>Estrategias Populares</h3>
<ul><li><strong>9 números 3 si 3:</strong> Buena relación coste/beneficio</li><li><strong>10 números 4 si 4:</strong> Mayor garantía de premio</li><li><strong>11 números 3 si 3:</strong> Máxima cobertura</li></ul>
<h3>Costes Típicos</h3>
<p>Los sistemas reducidos para El Gordo suelen costar entre 15€ y 45€, frente a los cientos de euros que costaría en múltiple.</p>';
    }
    
    // Métodos para contenido combinación ganadora
    private function getHtmlEuromillonesCombinacion(): string
    {
        return '<h2>¿Cómo es la Combinación Ganadora de Euromillones?</h2>
<p>La combinación ganadora de Euromillones consiste en 5 números principales (del 1 al 50) y 2 estrellas (del 1 al 12).</p>
<h3>Estructura de Premios</h3>
<p>Euromillones tiene 13 categorías de premios diferentes:</p>
<ul><li><strong>5+2:</strong> Bote (premio máximo)</li><li><strong>5+1:</strong> Segundo premio</li><li><strong>5+0:</strong> Tercer premio</li><li><strong>4+2:</strong> Cuarto premio</li><li><strong>4+1:</strong> Quinto premio</li><li>... y 8 categorías más</li></ul>
<h3>¿Cómo comprobar tu boleto?</h3>
<ol><li>Busca los 5 números principales en tu boleto</li><li>Busca las 2 estrellas</li><li>Compara con la combinación oficial</li><li>Consulta la tabla de premios</li></ol>
<h3>Dónde verificar resultados</h3>
<ul><li>Web oficial de Euromillones</li><li>Administraciones de Loterías</li><li>App oficial</li><li>Prensa especializada</li></ul>';
    }
    
    private function getHtmlBonolotoCombinacion(): string
    {
        return '<h2>¿Cómo es la Combinación Ganadora de Bonoloto?</h2>
<p>La combinación ganadora de Bonoloto consiste en 6 números principales seleccionados del 1 al 49.</p>
<h3>Categorías de Premios</h3>
<p>Bonoloto tiene 5 categorías de premios:</p>
<ul><li><strong>6 aciertos:</strong> Premio máximo</li><li><strong>5 aciertos:</strong> Segundo premio</li><li><strong>4 aciertos:</strong> Tercer premio</li><li><strong>3 aciertos:</strong> Cuarto premio</li><li><strong>Reintegro:</strong> Quinto premio (devolución del dinero)</li></ul>
<h3>¿Cómo comprobar tu boleto?</h3>
<ol><li>Verifica los 6 números de tu boleto</li><li>Compara con la combinación ganadora</li><li>Cuenta cuántos aciertos tienes</li><li>Consulta la tabla de premios</li></ol>
<h3>Características Especiales</h3>
<ul><li><strong>Sin reintegro fijo:</strong> Se genera aleatoriamente</li><li><strong>Joker opcional:</strong> 1€ adicional por combinación</li><li><strong>Múltiples sorteos:</strong> Puedes participar en varios días</li></ul>';
    }
    
    private function getHtmlPrimitivaCombinacion(): string
    {
        return '<h2>¿Cómo es la Combinación Ganadora de La Primitiva?</h2>
<p>La combinación ganadora de La Primitiva consiste en 6 números principales (1-49), 1 complementario (1-49) y 1 reintegro (0-9).</p>
<h3>Estructura Completa</h3>
<ul><li><strong>6 números:</strong> Combinación principal</li><li><strong>1 complementario:</strong> Para premios de 5+1</li><li><strong>1 reintegro:</strong> Para devolución y premios especiales</li></ul>
<h3>Categorías de Premios</h3>
<p>La Primitiva tiene 6 categorías principales:</p>
<ul><li><strong>6 aciertos:</strong> Bote</li><li><strong>5+complementario:</strong> Segundo premio</li><li><strong>5 aciertos:</strong> Tercer premio</li><li><strong>4 aciertos:</strong> Cuarto premio</li><li><strong>3 aciertos:</strong> Quinto premio</li><li><strong>Reintegro:</strong> Devolución</li></ul>
<h3>¿Cómo funciona el complementario?</h3>
<p>Si aciertas 5 números y el complementario, ganas el segundo premio. Si aciertas 5 números pero no el complementario, ganas el tercero.</p>';
    }
    
    private function getHtmlGordoCombinacion(): string
    {
        return '<h2>¿Cómo es la Combinación Ganadora de El Gordo?</h2>
<p>El Gordo de la Primitiva tiene la misma estructura que La Primitiva: 6 números (1-49), 1 complementario (1-49) y 1 reintegro (0-9).</p>
<h3>Diferencia Principal: El Bote</h3>
<p>El Gordo garantiza un bote mínimo de 5 millones de euros cada jueves, lo que lo hace especialmente atractivo.</p>
<h3>Categorías de Premios</h3>
<p>El Gordo tiene 6 categorías como La Primitiva:</p>
<ul><li><strong>6 aciertos:</strong> Bote mínimo 5M€</li><li><strong>5+complementario:</strong> Segundo premio</li><li><strong>5 aciertos:</strong> Tercer premio</li><li><strong>4 aciertos:</strong> Cuarto premio</li><li><strong>3 aciertos:</strong> Quinto premio</li><li><strong>Reintegro:</strong> Devolución</li></ul>
<h3>Ventaja del Sorteo Semanal</h3>
<ul><li><strong>Bote garantizado:</strong> Siempre hay premio gordo</li><li><strong>Menos competencia:</strong> Menos jugadores</li><li><strong>Más probabilidades:</strong> Por participación</li></ul>';
    }
}
