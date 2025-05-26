<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') - OVAs Académicas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #1a365d;    /* Azul oscuro */
            --color-secondary: #1c4532;  /* Verde oscuro */
            --color-white: #ffffff;
            --color-gray-50: #f9fafb;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;
        }

        /* Estilos base para mobile-first */
        .auth-container {
            min-height: 100vh;
            width: 100%;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-gray-50);
        }

        .auth-card {
            width: 100%;
            max-width: 28rem;
            margin: 0 auto;
            background: var(--color-white);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Ajustes para tablets y pantallas más grandes */
        @media (min-width: 640px) {
            .auth-container {
                padding: 1.5rem;
            }
        }

        @media (min-width: 768px) {
            .auth-container {
                padding: 2rem;
            }
        }

        /* Ajustes para pantallas grandes */
        @media (min-width: 1024px) {
            .auth-container {
                padding: 3rem;
            }
        }

        /* Ajustes para inputs en móviles */
        input, select, button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            font-size: 16px;
        }

        /* Mejoras de accesibilidad y usabilidad */
        .focus-ring {
            @apply focus:outline-none focus:ring-2 focus:ring-offset-2;
            focus-ring-color: var(--color-primary);
        }

        .input-field {
            @apply block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md text-base;
            @apply focus:ring-2 focus:ring-offset-2;
            @apply placeholder-gray-400;
            @apply transition duration-150 ease-in-out;
            border-color: var(--color-gray-300);
            focus-ring-color: var(--color-primary);
            focus-border-color: var(--color-primary);
        }

        .btn-primary {
            @apply w-full flex justify-center items-center py-3 px-6 rounded-lg;
            @apply text-base font-medium text-white;
            @apply transition duration-150 ease-in-out;
            @apply hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary;
            background-color: var(--color-primary);
        }

        .btn-primary i {
            @apply text-white;
        }

        .btn-secondary {
            @apply w-full flex justify-center items-center py-3 px-6 rounded-lg;
            @apply text-base font-medium text-white;
            @apply transition duration-150 ease-in-out;
            @apply hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary;
            background-color: var(--color-secondary);
        }

        .btn-secondary i {
            @apply text-white;
        }

        .text-primary {
            color: var(--color-primary);
        }

        .text-secondary {
            color: var(--color-secondary);
        }

        .bg-primary {
            background-color: var(--color-primary);
        }

        .bg-secondary {
            background-color: var(--color-secondary);
        }

        .border-primary {
            border-color: var(--color-primary);
        }

        .border-secondary {
            border-color: var(--color-secondary);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="auth-container">
        <div class="auth-card p-4 sm:p-6 md:p-8">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-primary">OVAs Académicas</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-2">@yield('subtitle')</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-4 sm:space-y-6">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
