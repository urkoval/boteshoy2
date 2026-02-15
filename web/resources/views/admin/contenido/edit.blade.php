@extends('layouts.app')

@section('title')
Editar Contenido
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('admin.contenido.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Volver a Contenido
                </a>
            </div>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Editar Contenido</h1>
            <p class="mt-2 text-gray-600">
                {{ $contenido->juego->nombre }} - {{ $contenido->tipo_contenido_label }}
            </p>
        </div>

        <!-- Form -->
        @include('admin.contenido.form')
    </div>
</div>
@endsection
