@extends('layouts.app')

@section('title', 'Perfil - OVAs Académicas')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">Información del Perfil</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Información personal y detalles de la cuenta.
                </p>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-full bg-indigo-600 flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">
                                    {{ substr($user->nombre_completo, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $user->nombre_completo }}</h4>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Identificación</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->identificacion }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Rol</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($user->isAdmin())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Administrador
                                        </span>
                                    @elseif($user->isDocente())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Docente
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Estudiante
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            @if($user->isEstudiante())
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Programa Académico</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->programaAcademico->nombre }}</dd>
                                </div>
                            @endif

                            @if($user->isDocente())
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Departamento Académico</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->departamento_academico }}</dd>
                                </div>
                            @endif

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Estado de la Cuenta</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($user->email_verified_at)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Verificado
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pendiente de Verificación
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            @if($user->two_factor_secret)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Autenticación de Dos Factores</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Habilitada
                                        </span>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-end">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($user->isEstudiante())
        <div class="mt-10">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Progreso Académico</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Resumen de tu actividad y progreso en los OVAs.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            OVAs Completados
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                                            {{ $user->ovasCompletados()->count() }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Evaluaciones Aprobadas
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-green-600">
                                            {{ $user->evaluacionesAprobadas()->count() }}
                                        </dd>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-lg font-medium text-gray-900">Últimas Actividades</h4>
                                <div class="mt-4 flow-root">
                                    <ul class="-my-5 divide-y divide-gray-200">
                                        @forelse($user->ultimasActividades() as $actividad)
                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        @if($actividad->tipo === 'ova')
                                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100">
                                                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                </svg>
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100">
                                                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $actividad->titulo }}
                                                        </p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $actividad->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        @if($actividad->tipo === 'ova')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                OVA
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Evaluación
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="py-4">
                                                <p class="text-sm text-gray-500 text-center">No hay actividades recientes</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($user->isDocente())
        <div class="mt-10">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Estadísticas de Docencia</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Resumen de tu actividad como docente.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            OVAs Creados
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                                            {{ $user->ovasCreados()->count() }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Estudiantes Activos
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-green-600">
                                            {{ $user->estudiantesActivos()->count() }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Evaluaciones Creadas
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-blue-600">
                                            {{ $user->evaluacionesCreadas()->count() }}
                                        </dd>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-lg font-medium text-gray-900">OVAs Recientes</h4>
                                <div class="mt-4 flow-root">
                                    <ul class="-my-5 divide-y divide-gray-200">
                                        @forelse($user->ovasRecientes() as $ova)
                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100">
                                                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $ova->titulo }}
                                                        </p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $ova->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ova->estado === 'publicado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ ucfirst($ova->estado) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="py-4">
                                                <p class="text-sm text-gray-500 text-center">No hay OVAs creados</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($user->isAdmin())
        <div class="mt-10">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Estadísticas del Sistema</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Resumen general de la plataforma.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Usuarios
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                                            {{ \App\Models\User::count() }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total OVAs
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-green-600">
                                            {{ \App\Models\Ova::count() }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Programas Activos
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-blue-600">
                                            {{ \App\Models\ProgramaAcademico::count() }}
                                        </dd>
                                    </div>
                                </div>

                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Evaluaciones
                                        </dt>
                                        <dd class="mt-1 text-3xl font-semibold text-purple-600">
                                            {{ \App\Models\EvaluacionFinal::count() }}
                                        </dd>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-lg font-medium text-gray-900">Actividad Reciente del Sistema</h4>
                                <div class="mt-4 flow-root">
                                    <ul class="-my-5 divide-y divide-gray-200">
                                        @forelse(\App\Models\Actividad::latest()->take(5)->get() as $actividad)
                                            <li class="py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100">
                                                            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $actividad->descripcion }}
                                                        </p>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $actividad->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            {{ $actividad->tipo }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="py-4">
                                                <p class="text-sm text-gray-500 text-center">No hay actividad reciente</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 