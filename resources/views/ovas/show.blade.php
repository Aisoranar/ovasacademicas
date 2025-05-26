@extends('layouts.app')

@section('title', $ova->titulo)

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Encabezado del OVA -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="relative">
            @if($ova->imagen_portada)
                <div class="h-48 w-full bg-gray-200">
                    <img src="{{ Storage::url($ova->imagen_portada) }}" alt="{{ $ova->titulo }}" class="w-full h-full object-cover">
                </div>
            @endif
            <div class="px-4 py-5 sm:px-6 {{ $ova->imagen_portada ? 'absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent' : '' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl leading-6 font-medium {{ $ova->imagen_portada ? 'text-white' : 'text-gray-900' }}">
                            {{ $ova->titulo }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm {{ $ova->imagen_portada ? 'text-gray-100' : 'text-gray-500' }}">
                            Creado por {{ $ova->docente->nombre_completo }} el {{ $ova->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        @can('update', $ova)
                            <a href="{{ route('ovas.edit', $ova) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                        @endcan
                        @can('delete', $ova)
                            <form action="{{ route('ovas.destroy', $ova) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('¿Estás seguro de que deseas eliminar este OVA?')">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado y Etiquetas -->
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <div class="flex flex-wrap items-center gap-4">
                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                    @if($ova->estado === 'publicado') bg-green-100 text-green-800
                    @elseif($ova->estado === 'borrador') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($ova->estado) }}
                </span>
                @foreach($ova->etiquetas as $etiqueta)
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $etiqueta->nombre }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $ova->descripcion }}
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Objetivos de Aprendizaje</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {!! nl2br(e($ova->objetivos)) !!}
                    </dd>
                </div>

                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Contenido</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 prose max-w-none">
                        {!! $ova->contenido !!}
                    </dd>
                </div>

                @if($ova->recursos)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Recursos Adicionales</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {!! nl2br(e($ova->recursos)) !!}
                        </dd>
                    </div>
                @endif

                @if($ova->evaluacion)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Evaluación</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {!! nl2br(e($ova->evaluacion)) !!}
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Sección de Comentarios -->
    @if($ova->estado === 'publicado')
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Comentarios y Discusión
                </h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                @auth
                    <form action="{{ route('ovas.comentarios.store', $ova) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="comentario" class="sr-only">Comentario</label>
                            <textarea id="comentario" name="comentario" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Escribe tu comentario..."></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Publicar Comentario
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-500">
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Inicia sesión
                        </a>
                        para participar en la discusión.
                    </p>
                @endauth

                <div class="mt-6 space-y-6">
                    @forelse($ova->comentarios as $comentario)
                        <div class="flex space-x-3">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="{{ $comentario->user->profile_photo_url }}" alt="{{ $comentario->user->nombre_completo }}">
                            </div>
                            <div class="flex-1 bg-gray-50 rounded-lg px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        {{ $comentario->user->nombre_completo }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $comentario->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700">
                                    {{ $comentario->contenido }}
                                </div>
                                @can('delete', $comentario)
                                    <div class="mt-2 flex justify-end">
                                        <form action="{{ route('ovas.comentarios.destroy', [$ova, $comentario]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">
                            No hay comentarios aún. ¡Sé el primero en comentar!
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .prose img {
        @apply rounded-lg shadow-lg;
    }
    .prose a {
        @apply text-indigo-600 hover:text-indigo-500;
    }
</style>
@endpush
@endsection 