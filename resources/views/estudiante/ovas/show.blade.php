@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('estudiante.ovas.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a OVAs
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($ova->imagen_portada)
            <img src="{{ asset('storage/' . $ova->imagen_portada) }}" alt="{{ $ova->titulo }}" class="w-full h-64 object-cover">
        @endif
        
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $ova->titulo }}</h1>
            
            <div class="flex items-center text-sm text-gray-500 mb-6">
                <i class="fas fa-bookmark mr-2"></i>
                <span>{{ $ova->tema->nombre }}</span>
                <span class="mx-2">•</span>
                <i class="fas fa-tasks mr-2"></i>
                <span>{{ $ova->actividades->count() }} actividades</span>
            </div>

            <div class="prose max-w-none mb-8">
                {!! $ova->descripcion !!}
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex -mb-px">
                    <button class="tab-button active px-4 py-2 text-blue-600 border-b-2 border-blue-600" data-tab="actividades">
                        <i class="fas fa-tasks mr-2"></i>
                        Actividades
                    </button>
                    <button class="tab-button px-4 py-2 text-gray-500 hover:text-gray-700" data-tab="foro">
                        <i class="fas fa-comments mr-2"></i>
                        Foro
                    </button>
                </nav>
            </div>

            <!-- Actividades Tab -->
            <div id="actividades" class="tab-content">
                @if($ova->actividades->isEmpty())
                    <p class="text-gray-600 text-center py-4">No hay actividades disponibles para este OVA.</p>
                @else
                    <div class="space-y-4">
                        @foreach($ova->actividades as $actividad)
                            <div class="border rounded-lg p-4 {{ $actividad->progreso && $actividad->progreso->completada ? 'bg-green-50' : 'bg-white' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $actividad->titulo }}</h3>
                                        <p class="text-gray-600 mt-1">{{ Str::limit($actividad->descripcion, 150) }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        @if($actividad->progreso && $actividad->progreso->completada)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Completada
                                            </span>
                                        @else
                                            <a href="{{ route('estudiante.actividades.show', $actividad) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-play mr-2"></i>
                                                Iniciar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Foro Tab -->
            <div id="foro" class="tab-content hidden">
                <div class="mb-6">
                    <a href="{{ route('estudiante.ovas.foro.create', $ova) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Discusión
                    </a>
                </div>

                @if($ova->threads->isEmpty())
                    <p class="text-gray-600 text-center py-4">No hay discusiones en el foro. ¡Sé el primero en iniciar una!</p>
                @else
                    <div class="space-y-4">
                        @foreach($ova->threads as $thread)
                            <div class="border rounded-lg p-4 bg-white">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <a href="{{ route('estudiante.ovas.foro.show', [$ova, $thread]) }}" class="hover:text-blue-600">
                                                {{ $thread->titulo }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Por {{ $thread->user->nombre_completo }} • {{ $thread->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-comments mr-2"></i>
                                        {{ $thread->replies->count() }} respuestas
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and hide all contents
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-500');
            });
            tabContents.forEach(content => content.classList.add('hidden'));

            // Add active class to clicked button and show corresponding content
            button.classList.add('active', 'text-blue-600', 'border-blue-600');
            button.classList.remove('text-gray-500');
            document.getElementById(button.dataset.tab).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection 