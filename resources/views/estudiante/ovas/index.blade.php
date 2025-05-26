@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">OVAs Disponibles</h1>
    </div>

    @if($ovas->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">No hay OVAs disponibles para tu programa académico en este momento.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ovas as $ova)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($ova->imagen_portada)
                        <img src="{{ asset('storage/' . $ova->imagen_portada) }}" alt="{{ $ova->titulo }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-book text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $ova->titulo }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($ova->descripcion, 100) }}</p>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-bookmark mr-2"></i>
                            <span>{{ $ova->tema->nombre }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-tasks mr-2"></i>
                            <span>{{ $ova->actividades->count() }} actividades</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('estudiante.ovas.show', $ova) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-eye mr-2"></i>
                                Ver OVA
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $ovas->links() }}
        </div>
    @endif
</div>
@endsection 