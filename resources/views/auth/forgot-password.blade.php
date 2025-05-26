@extends('layouts.auth')

@section('title', 'Recuperar Contraseña')

@section('subtitle', 'Te ayudaremos a recuperar tu acceso')

@section('content')
    <div class="space-y-6">
        <!-- Mensaje informativo -->
        <div class="text-center">
            <h2 class="text-xl font-semibold text-primary">Recuperar Contraseña</h2>
            <p class="mt-2 text-sm text-gray-600">
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña
            </p>
        </div>

        @if (session('status'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario de recuperación -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Campo de email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Correo Electrónico
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required
                        class="input-field pl-10"
                        placeholder="correo@ejemplo.com"
                        autocomplete="email"
                    >
                </div>
            </div>

            <!-- Botón de envío -->
            <div>
                <button 
                    type="submit" 
                    class="btn-primary"
                >
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Enlace
                </button>
            </div>
        </form>

        <!-- Separador -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">¿Recordaste tu contraseña?</span>
            </div>
        </div>

        <!-- Botón de login -->
        <div>
            <a 
                href="{{ route('login') }}" 
                class="btn-secondary"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Volver al Login
            </a>
        </div>
    </div>
@endsection 