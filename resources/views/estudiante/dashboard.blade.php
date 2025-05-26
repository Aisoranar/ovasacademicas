@extends('layouts.app')

@section('title', 'Dashboard del Estudiante')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Bienvenido, {{ auth()->user()->nombre_completo }}</h2>

                <!-- OVAs Disponibles -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">OVAs Disponibles</h3>
                    @if($ovas->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($ovas as $ova)
                                <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200 hover:shadow-lg transition duration-150">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $ova->titulo }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $ova->descripcion }}</p>
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <i class="fas fa-book mr-2"></i>
                                        <span>{{ $ova->tema->nombre }}</span>
                                    </div>
                                    <a href="{{ route('ovas.show', $ova) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver OVA
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No hay OVAs disponibles para tu programa académico en este momento.</p>
                    @endif
                </div>

                <!-- Actividades en Progreso -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Actividades en Progreso</h3>
                    @if($actividadesEnProgreso->count() > 0)
                        <div class="space-y-4">
                            @foreach($actividadesEnProgreso as $progreso)
                                <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $progreso->actividad->titulo }}</h4>
                                            <p class="text-sm text-gray-600">OVA: {{ $progreso->actividad->ova->titulo }}</p>
                                        </div>
                                        <a href="{{ route('actividades.show', $progreso->actividad) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition">
                                            Continuar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No tienes actividades en progreso.</p>
                    @endif
                </div>

                <!-- Actividades Completadas -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Actividades Completadas</h3>
                    @if($actividadesCompletadas->count() > 0)
                        <div class="space-y-4">
                            @foreach($actividadesCompletadas as $progreso)
                                <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $progreso->actividad->titulo }}</h4>
                                            <p class="text-sm text-gray-600">OVA: {{ $progreso->actividad->ova->titulo }}</p>
                                            <p class="text-sm text-green-600 mt-1">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Completada el {{ $progreso->updated_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <a href="{{ route('actividades.show', $progreso->actividad) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No has completado ninguna actividad aún.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 