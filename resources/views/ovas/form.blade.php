@extends('layouts.app')

@section('title', isset($ova) ? 'Editar OVA' : 'Crear OVA')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <form method="POST" action="{{ isset($ova) ? route('ovas.update', $ova) : route('ovas.store') }}" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-200">
        @csrf
        @if(isset($ova))
            @method('PUT')
        @endif

        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ isset($ova) ? 'Editar OVA' : 'Crear Nuevo OVA' }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Completa la información del OVA. Los campos marcados con * son obligatorios.
                    </p>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="titulo" class="block text-sm font-medium text-gray-700">
                            Título *
                        </label>
                        <div class="mt-1">
                            <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $ova->titulo ?? '') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('titulo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">
                            Descripción *
                        </label>
                        <div class="mt-1">
                            <textarea id="descripcion" name="descripcion" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('descripcion', $ova->descripcion ?? '') }}</textarea>
                        </div>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="objetivos" class="block text-sm font-medium text-gray-700">
                            Objetivos de Aprendizaje *
                        </label>
                        <div class="mt-1">
                            <textarea id="objetivos" name="objetivos" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('objetivos', $ova->objetivos ?? '') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Lista los objetivos de aprendizaje que se alcanzarán con este OVA.
                        </p>
                        @error('objetivos')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="contenido" class="block text-sm font-medium text-gray-700">
                            Contenido *
                        </label>
                        <div class="mt-1">
                            <textarea id="contenido" name="contenido" rows="10" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('contenido', $ova->contenido ?? '') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            El contenido principal del OVA. Puedes usar formato HTML para enriquecer el contenido.
                        </p>
                        @error('contenido')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="imagen_portada" class="block text-sm font-medium text-gray-700">
                            Imagen de Portada
                        </label>
                        <div class="mt-1 flex items-center">
                            @if(isset($ova) && $ova->imagen_portada)
                                <div class="flex-shrink-0 h-32 w-32">
                                    <img class="h-32 w-32 rounded-lg object-cover" src="{{ Storage::url($ova->imagen_portada) }}" alt="{{ $ova->titulo }}">
                                </div>
                            @endif
                            <div class="ml-4">
                                <input type="file" name="imagen_portada" id="imagen_portada"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300">
                                <p class="mt-2 text-sm text-gray-500">
                                    PNG, JPG o GIF hasta 2MB. Se recomienda una imagen de 1200x630 píxeles.
                                </p>
                            </div>
                        </div>
                        @error('imagen_portada')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="etiquetas" class="block text-sm font-medium text-gray-700">
                            Etiquetas
                        </label>
                        <div class="mt-1">
                            <select name="etiquetas[]" id="etiquetas" multiple
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                @foreach($etiquetas as $etiqueta)
                                    <option value="{{ $etiqueta->id }}" {{ isset($ova) && $ova->etiquetas->contains($etiqueta->id) ? 'selected' : '' }}>
                                        {{ $etiqueta->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Selecciona las etiquetas que mejor describan el contenido del OVA.
                        </p>
                        @error('etiquetas')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="estado" class="block text-sm font-medium text-gray-700">
                            Estado *
                        </label>
                        <div class="mt-1">
                            <select name="estado" id="estado" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="borrador" {{ old('estado', $ova->estado ?? '') === 'borrador' ? 'selected' : '' }}>Borrador</option>
                                <option value="publicado" {{ old('estado', $ova->estado ?? '') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                                <option value="archivado" {{ old('estado', $ova->estado ?? '') === 'archivado' ? 'selected' : '' }}>Archivado</option>
                            </select>
                        </div>
                        @error('estado')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="recursos" class="block text-sm font-medium text-gray-700">
                            Recursos Adicionales
                        </label>
                        <div class="mt-1">
                            <textarea id="recursos" name="recursos" rows="3"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('recursos', $ova->recursos ?? '') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Enlaces a recursos externos, documentos o materiales complementarios.
                        </p>
                        @error('recursos')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="evaluacion" class="block text-sm font-medium text-gray-700">
                            Evaluación
                        </label>
                        <div class="mt-1">
                            <textarea id="evaluacion" name="evaluacion" rows="3"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('evaluacion', $ova->evaluacion ?? '') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Criterios y métodos de evaluación para medir el logro de los objetivos.
                        </p>
                        @error('evaluacion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('ovas.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ isset($ova) ? 'Actualizar OVA' : 'Crear OVA' }}
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Inicializar el editor de texto enriquecido para el contenido
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(document.querySelector('#contenido'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'],
                    language: 'es'
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>
@endpush
@endsection 