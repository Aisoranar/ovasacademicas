@extends('layouts.auth')

@section('title', 'Restablecer Contraseña')

@section('subtitle', 'Crea una nueva contraseña segura')

@section('content')
    <div class="space-y-6">
        <!-- Mensaje informativo -->
        <div class="text-center">
            <h2 class="text-xl font-semibold text-primary">Restablecer Contraseña</h2>
            <p class="mt-2 text-sm text-gray-600">
                Ingresa tu nueva contraseña para restablecer tu acceso
            </p>
        </div>

        <!-- Formulario de restablecimiento -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
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
                        value="{{ $email ?? old('email') }}" 
                        required
                        class="input-field pl-10"
                        placeholder="correo@ejemplo.com"
                        autocomplete="email"
                    >
                </div>
            </div>

            <!-- Nueva Contraseña -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Nueva Contraseña
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        class="input-field pl-10"
                        placeholder="••••••••"
                        autocomplete="new-password"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirmar Nueva Contraseña
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        required
                        class="input-field pl-10"
                        placeholder="••••••••"
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <!-- Botón de restablecimiento -->
            <div>
                <button 
                    type="submit" 
                    class="btn-primary"
                >
                    <i class="fas fa-key mr-2"></i>
                    Restablecer Contraseña
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