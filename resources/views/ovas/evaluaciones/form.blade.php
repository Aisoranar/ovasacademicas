@extends('layouts.app')

@section('title', isset($evaluacion) ? 'Editar Evaluación' : 'Crear Evaluación')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <form method="POST" action="{{ isset($evaluacion) ? route('ovas.evaluaciones.update', $evaluacion) : route('ovas.evaluaciones.store') }}" class="space-y-8 divide-y divide-gray-200">
        @csrf
        @if(isset($evaluacion))
            @method('PUT')
        @endif

        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ isset($evaluacion) ? 'Editar Evaluación' : 'Crear Nueva Evaluación' }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Configure los detalles de la evaluación. Los campos marcados con * son obligatorios.
                    </p>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Selección de OVA -->
                    <div class="sm:col-span-4">
                        <label for="ova_id" class="block text-sm font-medium text-gray-700">
                            OVA *
                        </label>
                        <div class="mt-1">
                            <select name="ova_id" id="ova_id" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                {{ isset($evaluacion) ? 'disabled' : '' }}>
                                <option value="">Seleccione un OVA</option>
                                @foreach($ovas as $ova)
                                    <option value="{{ $ova->id }}" {{ old('ova_id', $evaluacion->ova_id ?? '') == $ova->id ? 'selected' : '' }}>
                                        {{ $ova->titulo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('ova_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selección de Estudiante -->
                    <div class="sm:col-span-4">
                        <label for="estudiante_id" class="block text-sm font-medium text-gray-700">
                            Estudiante *
                        </label>
                        <div class="mt-1">
                            <select name="estudiante_id" id="estudiante_id" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                {{ isset($evaluacion) ? 'disabled' : '' }}>
                                <option value="">Seleccione un estudiante</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}" {{ old('estudiante_id', $evaluacion->estudiante_id ?? '') == $estudiante->id ? 'selected' : '' }}>
                                        {{ $estudiante->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('estudiante_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Inicio -->
                    <div class="sm:col-span-3">
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">
                            Fecha de Inicio *
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" required
                                value="{{ old('fecha_inicio', isset($evaluacion) ? $evaluacion->fecha_inicio->format('Y-m-d\TH:i') : '') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('fecha_inicio')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Fin -->
                    <div class="sm:col-span-3">
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700">
                            Fecha de Fin *
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local" name="fecha_fin" id="fecha_fin" required
                                value="{{ old('fecha_fin', isset($evaluacion) ? $evaluacion->fecha_fin->format('Y-m-d\TH:i') : '') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('fecha_fin')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tiempo Límite -->
                    <div class="sm:col-span-3">
                        <label for="tiempo_limite" class="block text-sm font-medium text-gray-700">
                            Tiempo Límite (minutos) *
                        </label>
                        <div class="mt-1">
                            <input type="number" name="tiempo_limite" id="tiempo_limite" required min="1"
                                value="{{ old('tiempo_limite', $evaluacion->tiempo_limite ?? '') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('tiempo_limite')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Puntuación Mínima -->
                    <div class="sm:col-span-3">
                        <label for="puntuacion_minima" class="block text-sm font-medium text-gray-700">
                            Puntuación Mínima para Aprobar *
                        </label>
                        <div class="mt-1">
                            <input type="number" name="puntuacion_minima" id="puntuacion_minima" required min="0" max="100"
                                value="{{ old('puntuacion_minima', $evaluacion->puntuacion_minima ?? '') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('puntuacion_minima')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instrucciones -->
                    <div class="sm:col-span-6">
                        <label for="instrucciones" class="block text-sm font-medium text-gray-700">
                            Instrucciones *
                        </label>
                        <div class="mt-1">
                            <textarea id="instrucciones" name="instrucciones" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('instrucciones', $evaluacion->instrucciones ?? '') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Instrucciones generales para la evaluación.
                        </p>
                        @error('instrucciones')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Preguntas -->
            <div class="pt-8">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Preguntas
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Agregue las preguntas para la evaluación. Puede incluir preguntas de opción múltiple y preguntas abiertas.
                    </p>
                </div>

                <div class="mt-6 space-y-8" id="preguntas-container">
                    <!-- Las preguntas se agregarán dinámicamente aquí -->
                    @if(isset($evaluacion) && $evaluacion->preguntas->count() > 0)
                        @foreach($evaluacion->preguntas as $index => $pregunta)
                            <div class="pregunta-item bg-white shadow sm:rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-4">
                                            <label class="block text-sm font-medium text-gray-700">
                                                Pregunta {{ $index + 1 }} *
                                            </label>
                                            <div class="mt-1">
                                                <input type="text" name="preguntas[{{ $index }}][pregunta]" required
                                                    value="{{ $pregunta->pregunta }}"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">
                                                Tipo *
                                            </label>
                                            <div class="mt-1">
                                                <select name="preguntas[{{ $index }}][tipo]" required
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                    <option value="opcion_multiple" {{ $pregunta->tipo === 'opcion_multiple' ? 'selected' : '' }}>Opción Múltiple</option>
                                                    <option value="abierta" {{ $pregunta->tipo === 'abierta' ? 'selected' : '' }}>Abierta</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700">
                                                Descripción
                                            </label>
                                            <div class="mt-1">
                                                <textarea name="preguntas[{{ $index }}][descripcion]" rows="2"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $pregunta->descripcion }}</textarea>
                                            </div>
                                        </div>

                                        @if($pregunta->tipo === 'opcion_multiple')
                                            <div class="sm:col-span-6 opciones-container">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Opciones *
                                                </label>
                                                <div class="mt-2 space-y-2">
                                                    @foreach($pregunta->opciones as $opcionIndex => $opcion)
                                                        <div class="flex items-center space-x-2">
                                                            <input type="radio" name="preguntas[{{ $index }}][respuesta_correcta]" value="{{ $opcionIndex }}"
                                                                {{ $opcion->es_correcta ? 'checked' : '' }}
                                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                            <input type="text" name="preguntas[{{ $index }}][opciones][]" required
                                                                value="{{ $opcion->texto }}"
                                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                            <button type="button" class="eliminar-opcion text-red-600 hover:text-red-900">
                                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="agregar-opcion mt-2 inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Agregar Opción
                                                </button>
                                            </div>
                                        @endif

                                        <div class="sm:col-span-6 flex justify-end">
                                            <button type="button" class="eliminar-pregunta inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Eliminar Pregunta
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="mt-4">
                    <button type="button" id="agregar-pregunta" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Agregar Pregunta
                    </button>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('ovas.evaluaciones.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ isset($evaluacion) ? 'Actualizar Evaluación' : 'Crear Evaluación' }}
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preguntasContainer = document.getElementById('preguntas-container');
        const agregarPreguntaBtn = document.getElementById('agregar-pregunta');
        let preguntaCount = {{ isset($evaluacion) ? $evaluacion->preguntas->count() : 0 }};

        // Función para crear una nueva pregunta
        function crearPregunta() {
            const preguntaHtml = `
                <div class="pregunta-item bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Pregunta ${preguntaCount + 1} *
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="preguntas[${preguntaCount}][pregunta]" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo *
                                </label>
                                <div class="mt-1">
                                    <select name="preguntas[${preguntaCount}][tipo]" required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md tipo-pregunta">
                                        <option value="opcion_multiple">Opción Múltiple</option>
                                        <option value="abierta">Abierta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700">
                                    Descripción
                                </label>
                                <div class="mt-1">
                                    <textarea name="preguntas[${preguntaCount}][descripcion]" rows="2"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>

                            <div class="sm:col-span-6 opciones-container" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700">
                                    Opciones *
                                </label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center space-x-2">
                                        <input type="radio" name="preguntas[${preguntaCount}][respuesta_correcta]" value="0" checked
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <input type="text" name="preguntas[${preguntaCount}][opciones][]" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <button type="button" class="eliminar-opcion text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="agregar-opcion mt-2 inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Agregar Opción
                                </button>
                            </div>

                            <div class="sm:col-span-6 flex justify-end">
                                <button type="button" class="eliminar-pregunta inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Eliminar Pregunta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            preguntasContainer.insertAdjacentHTML('beforeend', preguntaHtml);
            preguntaCount++;

            // Actualizar números de preguntas
            actualizarNumerosPreguntas();
        }

        // Función para actualizar números de preguntas
        function actualizarNumerosPreguntas() {
            document.querySelectorAll('.pregunta-item').forEach((item, index) => {
                const label = item.querySelector('label');
                label.textContent = `Pregunta ${index + 1} *`;
            });
        }

        // Event Listeners
        agregarPreguntaBtn.addEventListener('click', crearPregunta);

        preguntasContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('eliminar-pregunta')) {
                if (confirm('¿Estás seguro de que deseas eliminar esta pregunta?')) {
                    e.target.closest('.pregunta-item').remove();
                    actualizarNumerosPreguntas();
                }
            }

            if (e.target.classList.contains('agregar-opcion')) {
                const opcionesContainer = e.target.previousElementSibling;
                const preguntaIndex = opcionesContainer.closest('.pregunta-item').querySelector('.tipo-pregunta').name.match(/\[(\d+)\]/)[1];
                const opcionCount = opcionesContainer.querySelectorAll('.flex.items-center').length;

                const opcionHtml = `
                    <div class="flex items-center space-x-2">
                        <input type="radio" name="preguntas[${preguntaIndex}][respuesta_correcta]" value="${opcionCount}"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                        <input type="text" name="preguntas[${preguntaIndex}][opciones][]" required
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <button type="button" class="eliminar-opcion text-red-600 hover:text-red-900">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;

                opcionesContainer.insertAdjacentHTML('beforeend', opcionHtml);
            }

            if (e.target.classList.contains('eliminar-opcion')) {
                const opcionesContainer = e.target.closest('.opciones-container');
                if (opcionesContainer.querySelectorAll('.flex.items-center').length > 1) {
                    e.target.closest('.flex.items-center').remove();
                } else {
                    alert('Debe haber al menos una opción.');
                }
            }
        });

        preguntasContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('tipo-pregunta')) {
                const opcionesContainer = e.target.closest('.pregunta-item').querySelector('.opciones-container');
                opcionesContainer.style.display = e.target.value === 'opcion_multiple' ? 'block' : 'none';
            }
        });

        // Mostrar/ocultar opciones según el tipo de pregunta al cargar
        document.querySelectorAll('.tipo-pregunta').forEach(select => {
            const opcionesContainer = select.closest('.pregunta-item').querySelector('.opciones-container');
            opcionesContainer.style.display = select.value === 'opcion_multiple' ? 'block' : 'none';
        });
    });
</script>
@endpush
@endsection 