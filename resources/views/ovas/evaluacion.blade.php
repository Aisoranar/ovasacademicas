@extends('layouts.app')

@section('title', 'Evaluación - ' . $ova->titulo)

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <!-- Encabezado -->
        <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Evaluación: {{ $ova->titulo }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Complete la evaluación para este OVA. Sus respuestas serán revisadas por el docente.
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        {{ $evaluacion->estado }}
                    </span>
                    @if($evaluacion->estado === 'pendiente')
                        <span class="text-sm text-gray-500">
                            Tiempo restante: {{ $evaluacion->tiempo_restante }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulario de Evaluación -->
        <form action="{{ route('ovas.evaluacion.store', [$ova, $evaluacion]) }}" method="POST" class="border-t border-gray-200">
            @csrf
            @method('PUT')

            <div class="px-4 py-5 sm:p-6 space-y-8">
                <!-- Preguntas de Opción Múltiple -->
                @foreach($evaluacion->preguntas as $pregunta)
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-base font-medium text-gray-900">
                                        {{ $loop->iteration }}. {{ $pregunta->pregunta }}
                                    </h4>
                                    @if($pregunta->descripcion)
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $pregunta->descripcion }}
                                        </p>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    @foreach($pregunta->opciones as $opcion)
                                        <div class="flex items-center">
                                            <input type="radio" 
                                                name="respuestas[{{ $pregunta->id }}]" 
                                                id="opcion_{{ $opcion->id }}"
                                                value="{{ $opcion->id }}"
                                                {{ old("respuestas.{$pregunta->id}") == $opcion->id ? 'checked' : '' }}
                                                {{ $evaluacion->estado !== 'pendiente' ? 'disabled' : '' }}
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="opcion_{{ $opcion->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                {{ $opcion->texto }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                @error("respuestas.{$pregunta->id}")
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Preguntas Abiertas -->
                @foreach($evaluacion->preguntas_abiertas as $pregunta)
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-base font-medium text-gray-900">
                                        {{ $loop->iteration + $evaluacion->preguntas->count() }}. {{ $pregunta->pregunta }}
                                    </h4>
                                    @if($pregunta->descripcion)
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $pregunta->descripcion }}
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <textarea
                                        name="respuestas_abiertas[{{ $pregunta->id }}]"
                                        rows="4"
                                        {{ $evaluacion->estado !== 'pendiente' ? 'disabled' : '' }}
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Escriba su respuesta aquí...">{{ old("respuestas_abiertas.{$pregunta->id}", $pregunta->respuesta_usuario) }}</textarea>
                                </div>

                                @error("respuestas_abiertas.{$pregunta->id}")
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Resultados (si la evaluación está completada) -->
                @if($evaluacion->estado === 'completada')
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Resultados</h4>
                            
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Puntuación Total
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                            {{ $evaluacion->puntuacion_total }}/{{ $evaluacion->puntuacion_maxima }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Estado
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold {{ $evaluacion->aprobada ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $evaluacion->aprobada ? 'Aprobada' : 'No Aprobada' }}
                                        </dd>
                                    </div>
                                </div>
                            </div>

                            @if($evaluacion->retroalimentacion)
                                <div class="mt-6">
                                    <h5 class="text-sm font-medium text-gray-900">Retroalimentación del Docente</h5>
                                    <div class="mt-2 text-sm text-gray-700 bg-gray-50 rounded-lg p-4">
                                        {!! nl2br(e($evaluacion->retroalimentacion)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Botones de Acción -->
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                @if($evaluacion->estado === 'pendiente')
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Enviar Evaluación
                    </button>
                @else
                    <a href="{{ route('ovas.show', $ova) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Volver al OVA
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Mostrar advertencia al intentar salir sin guardar
    window.addEventListener('beforeunload', function(e) {
        if (document.querySelector('form').checkValidity()) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
@endpush
@endsection 