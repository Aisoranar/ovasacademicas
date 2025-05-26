@extends('layouts.app')

@section('title', 'Calificar Evaluación')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Calificar Evaluación
            </h2>
            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ $evaluacion->estudiante->nombre_completo }}
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ $evaluacion->ova->titulo }}
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Enviada el {{ $evaluacion->fecha_envio->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('ovas.evaluaciones.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Volver
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('ovas.evaluaciones.calificar', $evaluacion) }}" class="mt-8 space-y-8 divide-y divide-gray-200">
        @csrf
        @method('PUT')

        <div class="space-y-8 divide-y divide-gray-200">
            <!-- Resumen de la Evaluación -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Resumen de la Evaluación
                    </h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Tiempo Utilizado
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $evaluacion->tiempo_utilizado }} minutos
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Puntuación Automática
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $evaluacion->puntuacion_automatica }}%
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Puntuación Mínima
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $evaluacion->puntuacion_minima }}%
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Estado
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $evaluacion->puntuacion_automatica >= $evaluacion->puntuacion_minima ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $evaluacion->puntuacion_automatica >= $evaluacion->puntuacion_minima ? 'Aprobado' : 'No Aprobado' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Preguntas y Respuestas -->
            <div class="pt-8">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Preguntas y Respuestas
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Revise y califique las respuestas del estudiante. Las preguntas de opción múltiple ya han sido calificadas automáticamente.
                    </p>
                </div>

                <div class="mt-6 space-y-8">
                    @foreach($evaluacion->preguntas as $index => $pregunta)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-medium text-gray-900">
                                        Pregunta {{ $index + 1 }}
                                    </h4>
                                    @if($pregunta->tipo === 'opcion_multiple')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pregunta->respuesta_correcta ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $pregunta->respuesta_correcta ? 'Correcta' : 'Incorrecta' }}
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $pregunta->pregunta }}
                                </p>
                                @if($pregunta->descripcion)
                                    <p class="mt-2 text-sm text-gray-500">
                                        {{ $pregunta->descripcion }}
                                    </p>
                                @endif
                            </div>

                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                @if($pregunta->tipo === 'opcion_multiple')
                                    <div class="space-y-4">
                                        @foreach($pregunta->opciones as $opcionIndex => $opcion)
                                            <div class="flex items-center">
                                                <input type="radio" disabled
                                                    {{ $pregunta->respuesta_estudiante == $opcionIndex ? 'checked' : '' }}
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                                <label class="ml-3 block text-sm font-medium text-gray-700 {{ $opcion->es_correcta ? 'text-green-600' : '' }}">
                                                    {{ $opcion->texto }}
                                                    @if($opcion->es_correcta)
                                                        <span class="ml-2 text-xs text-green-500">(Respuesta correcta)</span>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Respuesta del Estudiante
                                            </label>
                                            <div class="mt-1">
                                                <p class="text-sm text-gray-900">
                                                    {{ $pregunta->respuesta_estudiante }}
                                                </p>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="puntuacion_{{ $pregunta->id }}" class="block text-sm font-medium text-gray-700">
                                                Puntuación (0-100)
                                            </label>
                                            <div class="mt-1">
                                                <input type="number" name="puntuaciones[{{ $pregunta->id }}]" id="puntuacion_{{ $pregunta->id }}"
                                                    min="0" max="100" required
                                                    value="{{ old('puntuaciones.' . $pregunta->id, $pregunta->puntuacion ?? '') }}"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            @error('puntuaciones.' . $pregunta->id)
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="retroalimentacion_{{ $pregunta->id }}" class="block text-sm font-medium text-gray-700">
                                                Retroalimentación
                                            </label>
                                            <div class="mt-1">
                                                <textarea name="retroalimentaciones[{{ $pregunta->id }}]" id="retroalimentacion_{{ $pregunta->id }}" rows="3"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('retroalimentaciones.' . $pregunta->id, $pregunta->retroalimentacion ?? '') }}</textarea>
                                            </div>
                                            @error('retroalimentaciones.' . $pregunta->id)
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Retroalimentación General -->
            <div class="pt-8">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Retroalimentación General
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Proporcione una retroalimentación general sobre la evaluación.
                    </p>
                </div>

                <div class="mt-6">
                    <div>
                        <label for="retroalimentacion_general" class="block text-sm font-medium text-gray-700">
                            Comentarios
                        </label>
                        <div class="mt-1">
                            <textarea id="retroalimentacion_general" name="retroalimentacion_general" rows="4"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('retroalimentacion_general', $evaluacion->retroalimentacion_general ?? '') }}</textarea>
                        </div>
                        @error('retroalimentacion_general')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('ovas.evaluaciones.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Guardar Calificación
                </button>
            </div>
        </div>
    </form>
</div>
@endsection 