@extends('layouts.auth')

@section('title', 'Verificar Email')

@section('subtitle', 'Confirma tu dirección de correo electrónico')

@section('content')
    <div class="space-y-6">
        <!-- Mensaje informativo -->
        <div class="text-center">
            <div class="mb-4">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary/10">
                    <i class="fas fa-envelope-open-text text-3xl text-primary"></i>
                </div>
            </div>
            <h2 class="text-xl font-semibold text-primary">Verifica tu Email</h2>
            <p class="mt-2 text-sm text-gray-600">
                Gracias por registrarte en OVAs Académicas. Por favor, verifica tu dirección de correo electrónico para continuar.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario de verificación -->
        <div class="bg-gray-50 rounded-lg p-4 space-y-4">
            <p class="text-sm text-gray-600 text-center">
                Si no recibiste el correo de verificación, puedes solicitar uno nuevo haciendo clic en el botón de abajo.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                @csrf
                <button 
                    type="submit" 
                    class="btn-primary w-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                >
                    <i class="fas fa-paper-plane mr-2"></i>
                    Reenviar Email de Verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="space-y-4">
                @csrf
                <button 
                    type="submit" 
                    class="btn-secondary w-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary"
                >
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>

        <!-- Separador -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">¿Necesitas ayuda?</span>
            </div>
        </div>

        <!-- Enlace de soporte -->
        <div class="text-center space-y-2">
            <p class="text-sm text-gray-600">
                Si tienes problemas para verificar tu correo electrónico, nuestro equipo de soporte está aquí para ayudarte.
            </p>
            <a 
                href="#" 
                class="inline-flex items-center text-sm font-medium text-primary hover:text-secondary transition duration-150 ease-in-out"
            >
                <i class="fas fa-question-circle mr-2"></i>
                Contactar Soporte Técnico
            </a>
        </div>
    </div>
@endsection 