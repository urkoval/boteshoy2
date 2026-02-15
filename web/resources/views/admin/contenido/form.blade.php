{{-- Formulario para crear/editar contenido --}}
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ isset($contenido) ? route('admin.contenido.update', $contenido) : route('admin.contenido.store') }}" method="POST">
            @csrf
            @isset($contenido)
                @method('PUT')
            @endisset

            <!-- Información básica -->
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="juego_id" class="block text-sm font-medium text-gray-700">Juego</label>
                        <select id="juego_id" name="juego_id" @isset($contenido) disabled @endisset class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Seleccionar juego</option>
                            @foreach($juegos as $juego)
                                <option value="{{ $juego->id }}" {{ (isset($contenido) ? old('juego_id', $contenido->juego_id) : old('juego_id')) == $juego->id ? 'selected' : '' }}>
                                    {{ $juego->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @isset($contenido)
                            <input type="hidden" name="juego_id" value="{{ $contenido->juego_id }}">
                        @endisset
                        @error('juego_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tipo_contenido" class="block text-sm font-medium text-gray-700">Tipo de Contenido</label>
                        <select id="tipo_contenido" name="tipo_contenido" @isset($contenido) disabled @endisset class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Seleccionar tipo</option>
                            @foreach($tiposContenido as $key => $label)
                                <option value="{{ $key }}" {{ (isset($contenido) ? old('tipo_contenido', $contenido->tipo_contenido) : old('tipo_contenido')) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @isset($contenido)
                            <input type="hidden" name="tipo_contenido" value="{{ $contenido->tipo_contenido }}">
                        @endisset
                        @error('tipo_contenido')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SEO -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="seo_title" class="block text-sm font-medium text-gray-700">Título SEO (máx. 60 caracteres)</label>
                            <input type="text" name="seo_title" id="seo_title" maxlength="60" value="{{ old('seo_title', $contenido->seo_title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">{{ Str::length(old('seo_title', $contenido->seo_title ?? '')) }}/60 caracteres</p>
                            @error('seo_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description (máx. 160 caracteres)</label>
                            <textarea name="meta_description" id="meta_description" rows="3" maxlength="160" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('meta_description', $contenido->meta_description ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">{{ Str::length(old('meta_description', $contenido->meta_description ?? '')) }}/160 caracteres</p>
                            @error('meta_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="h1_principal" class="block text-sm font-medium text-gray-700">H1 Principal (máx. 100 caracteres)</label>
                            <input type="text" name="h1_principal" id="h1_principal" maxlength="100" value="{{ old('h1_principal', $contenido->h1_principal ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">{{ Str::length(old('h1_principal', $contenido->h1_principal ?? '')) }}/100 caracteres</p>
                            @error('h1_principal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contenido Principal</h3>
                    
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button type="button" onclick="showTab('html')" id="html-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                HTML
                            </button>
                            <button type="button" onclick="showTab('markdown')" id="markdown-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Markdown
                            </button>
                        </nav>
                    </div>

                    <!-- HTML Tab -->
                    <div id="html-content" class="tab-content mt-4">
                        <label for="contenido_html" class="block text-sm font-medium text-gray-700 mb-2">Contenido HTML</label>
                        <textarea name="contenido_html" id="contenido_html" rows="15" class="tinymce-editor mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('contenido_html', $contenido->contenido_html ?? '') }}</textarea>
                    </div>

                    <!-- Markdown Tab -->
                    <div id="markdown-content" class="tab-content mt-4 hidden">
                        <label for="contenido_markdown" class="block text-sm font-medium text-gray-700 mb-2">Contenido Markdown</label>
                        <textarea name="contenido_markdown" id="contenido_markdown" rows="15" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono text-sm">{{ old('contenido_markdown', $contenido->contenido_markdown ?? '') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Usa Markdown para contenido estructurado. Ideal para herramientas de IA.</p>
                    </div>
                </div>

                <!-- Open Graph -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Open Graph (Redes Sociales)</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="og_title" class="block text-sm font-medium text-gray-700">OG Title (opcional)</label>
                            <input type="text" name="og_title" id="og_title" maxlength="60" value="{{ old('og_title', $contenido->og_title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Si no se completa, usa el Título SEO</p>
                        </div>

                        <div>
                            <label for="og_description" class="block text-sm font-medium text-gray-700">OG Description (opcional)</label>
                            <textarea name="og_description" id="og_description" rows="2" maxlength="160" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('og_description', $contenido->og_description ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Si no se completa, usa la Meta Description</p>
                        </div>

                        <div>
                            <label for="og_image" class="block text-sm font-medium text-gray-700">OG Image (opcional)</label>
                            <input type="text" name="og_image" id="og_image" value="{{ old('og_image', $contenido->og_image ?? '') }}" placeholder="/images/og-euromillones-multiples.jpg" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">URL de la imagen para redes sociales</p>
                        </div>
                    </div>
                </div>

                <!-- Estado -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="activo" id="activo" value="1" {{ (isset($contenido) ? old('activo', $contenido->activo) : old('activo', true)) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="activo" class="ml-2 block text-sm text-gray-900">Contenido activo</label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">El contenido solo será visible si está activo</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ isset($contenido) ? 'Actualizar' : 'Crear' }} Contenido
                </button>
                <a href="{{ route('admin.contenido.index') }}" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// TinyMCE initialization
tinymce.init({
    selector: '.tinymce-editor',
    height: 400,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | \
               alignleft aligncenter alignright alignjustify | \
               bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif; font-size:14px }'
});

// Tab switching
function showTab(tab) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected content
    document.getElementById(tab + '-content').classList.remove('hidden');
    
    // Add active state to selected tab
    const activeTab = document.getElementById(tab + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-blue-500', 'text-blue-600');
}

// Character counters
document.getElementById('seo_title').addEventListener('input', function() {
    this.nextElementSibling.textContent = this.value.length + '/60 caracteres';
});

document.getElementById('meta_description').addEventListener('input', function() {
    this.nextElementSibling.textContent = this.value.length + '/160 caracteres';
});

document.getElementById('h1_principal').addEventListener('input', function() {
    this.nextElementSibling.textContent = this.value.length + '/100 caracteres';
});
</script>
