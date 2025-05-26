@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Política de Privacidad</h1>

        <div class="prose prose-blue max-w-none">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">1. Información que Recopilamos</h2>
            <p class="mb-4">
                Recopilamos la siguiente información personal:
            </p>
            <ul class="list-disc pl-6 mb-4">
                <li>Nombre completo</li>
                <li>Número de identificación</li>
                <li>Correo electrónico institucional</li>
                <li>Programa académico</li>
                <li>Información específica según el rol (semestre para estudiantes, departamento para docentes)</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">2. Uso de la Información</h2>
            <p class="mb-4">
                La información recopilada se utiliza para:
            </p>
            <ul class="list-disc pl-6 mb-4">
                <li>Gestionar su cuenta y acceso a la plataforma</li>
                <li>Personalizar su experiencia de aprendizaje</li>
                <li>Comunicar información importante sobre su cuenta o la plataforma</li>
                <li>Mejorar nuestros servicios educativos</li>
                <li>Cumplir con requisitos legales y académicos</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">3. Protección de Datos</h2>
            <p class="mb-4">
                La Universidad de la Paz implementa medidas de seguridad técnicas y organizativas para proteger sus datos personales contra el acceso no autorizado, la pérdida o la alteración.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">4. Compartir Información</h2>
            <p class="mb-4">
                No compartimos su información personal con terceros, excepto cuando:
            </p>
            <ul class="list-disc pl-6 mb-4">
                <li>Es necesario para el funcionamiento de la plataforma</li>
                <li>Existe un requisito legal</li>
                <li>Usted ha dado su consentimiento explícito</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">5. Sus Derechos</h2>
            <p class="mb-4">
                Usted tiene derecho a:
            </p>
            <ul class="list-disc pl-6 mb-4">
                <li>Acceder a sus datos personales</li>
                <li>Corregir información inexacta</li>
                <li>Solicitar la eliminación de sus datos</li>
                <li>Oponerse al procesamiento de sus datos</li>
                <li>Retirar su consentimiento en cualquier momento</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">6. Cookies y Tecnologías Similares</h2>
            <p class="mb-4">
                Utilizamos cookies y tecnologías similares para mejorar su experiencia en la plataforma. Puede controlar el uso de cookies a través de la configuración de su navegador.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">7. Cambios en la Política de Privacidad</h2>
            <p class="mb-4">
                Nos reservamos el derecho de modificar esta política de privacidad en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación en la plataforma.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">8. Contacto</h2>
            <p class="mb-4">
                Para cualquier consulta sobre esta política de privacidad, por favor contacte a:
                <br>
                Email: privacidad@unipaz.edu.co
                <br>
                Teléfono: (123) 456-7890
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('register') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al Registro
            </a>
        </div>
    </div>
</div>
@endsection 