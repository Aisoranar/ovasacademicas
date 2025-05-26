@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@section('subtitle', 'Bienvenido de nuevo')

@section('content')
    <div class="space-y-6">
        <!-- Mensaje de bienvenida -->
        <div class="text-center">
            <h2 class="text-xl font-semibold text-primary">¡Bienvenido!</h2>
            <p class="mt-2 text-sm text-gray-600">Ingresa tus credenciales para continuar</p>
        </div>

        <!-- Formulario de login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
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

            <!-- Campo de contraseña -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Contraseña
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
                        autocomplete="current-password"
                    >
                </div>
            </div>

            <!-- Opciones adicionales -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded transition duration-150 ease-in-out"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Recordarme
                    </label>
                </div>

                <a 
                    href="{{ route('password.request') }}" 
                    class="text-sm font-medium text-primary hover:text-secondary transition duration-150 ease-in-out"
                >
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <!-- Botón de inicio de sesión -->
            <div>
                <button 
                    type="submit" 
                    class="btn-primary"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <!-- Separador -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">¿No tienes una cuenta?</span>
            </div>
        </div>

        <!-- Botón de registro -->
        <div>
            <a 
                href="{{ route('register') }}" 
                class="btn-secondary"
            >
                <i class="fas fa-user-plus mr-2"></i>
                Crear una cuenta
            </a>
        </div>
    </div>
@endsection 