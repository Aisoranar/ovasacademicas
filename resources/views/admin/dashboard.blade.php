@extends('layouts.app')

@section('title', 'Dashboard Administrativo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Administrativo</h1>

    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total OVAs -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total OVAs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['total_ovas'] }}</p>
                </div>
            </div>
        </div>

        <!-- OVAs Activos -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">OVAs Activos</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['ovas_activos'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Usuarios</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['total_usuarios'] }}</p>
                </div>
            </div>
        </div>

        <!-- Estudiantes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Estudiantes</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['estudiantes'] }}</p>
                </div>
            </div>
        </div>

        <!-- Docentes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Docentes</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['docentes'] }}</p>
                </div>
            </div>
        </div>

        <!-- Programas Académicos -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <i class="fas fa-university text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Programas Académicos</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['programas_academicos'] }}</p>
                </div>
            </div>
        </div>

        <!-- Temas -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Temas</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['temas'] }}</p>
                </div>
            </div>
        </div>

        <!-- Actividades -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-teal-100 text-teal-600">
                    <i class="fas fa-tasks text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Actividades</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['actividades'] }}</p>
                </div>
            </div>
        </div>

        <!-- Evaluaciones -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Evaluaciones</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $estadisticas['evaluaciones'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- OVAs Recientes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">OVAs Recientes</h2>
            </div>
            <div class="p-6">
                @if($ovasRecientes->count() > 0)
                    <div class="space-y-4">
                        @foreach($ovasRecientes as $ova)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $ova->nombre }}</h3>
                                    <p class="text-sm text-gray-600">Docente: {{ $ova->docente->nombre_completo }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full {{ $ova->estado === 'publicado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($ova->estado) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay OVAs recientes.</p>
                @endif
            </div>
        </div>

        <!-- Usuarios Recientes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Usuarios Recientes</h2>
            </div>
            <div class="p-6">
                @if($usuariosRecientes->count() > 0)
                    <div class="space-y-4">
                        @foreach($usuariosRecientes as $usuario)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $usuario->nombre_completo }}</h3>
                                    <p class="text-sm text-gray-600">{{ $usuario->email }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full {{ $usuario->rol === 'estudiante' ? 'bg-blue-100 text-blue-800' : ($usuario->rol === 'docente' ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($usuario->rol) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay usuarios recientes.</p>
                @endif
            </div>
        </div>

        <!-- Programas Populares -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Programas Populares</h2>
            </div>
            <div class="p-6">
                @if($programasPopulares->count() > 0)
                    <div class="space-y-4">
                        @foreach($programasPopulares as $programa)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $programa->nombre }}</h3>
                                    <p class="text-sm text-gray-600">{{ $programa->ovas_count }} OVAs</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay programas académicos.</p>
                @endif
            </div>
        </div>

        <!-- Temas Populares -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Temas Populares</h2>
            </div>
            <div class="p-6">
                @if($temasPopulares->count() > 0)
                    <div class="space-y-4">
                        @foreach($temasPopulares as $tema)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $tema->nombre }}</h3>
                                    <p class="text-sm text-gray-600">{{ $tema->ovas_count }} OVAs</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay temas disponibles.</p>
                @endif
            </div>
        </div>

        <!-- Actividad Reciente de Estudiantes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Actividad Reciente de Estudiantes</h2>
            </div>
            <div class="p-6">
                @if($actividadEstudiantes->count() > 0)
                    <div class="space-y-4">
                        @foreach($actividadEstudiantes as $actividad)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $actividad->estudiante->nombre_completo }}</h3>
                                    <p class="text-sm text-gray-600">{{ $actividad->actividad->ova->nombre }}</p>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $actividad->created_at->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay actividad reciente de estudiantes.</p>
                @endif
            </div>
        </div>

        <!-- Intentos de Evaluación Recientes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Intentos de Evaluación Recientes</h2>
            </div>
            <div class="p-6">
                @if($intentosEvaluacion->count() > 0)
                    <div class="space-y-4">
                        @foreach($intentosEvaluacion as $intento)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $intento->estudiante->nombre_completo }}</h3>
                                    <p class="text-sm text-gray-600">{{ $intento->evaluacionFinal->ova->nombre }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-medium {{ $intento->puntaje_obtenido >= $intento->evaluacionFinal->puntaje_minimo ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $intento->puntaje_obtenido }} pts
                                    </span>
                                    <p class="text-xs text-gray-500">{{ $intento->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay intentos de evaluación recientes.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 