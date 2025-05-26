@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Términos y Condiciones</h1>

        <div class="prose prose-blue max-w-none">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">1. Aceptación de los Términos</h2>
            <p class="mb-4">
                Al acceder y utilizar la plataforma de OVAs Académicas de la Universidad de la Paz, usted acepta estar sujeto a estos términos y condiciones. Si no está de acuerdo con alguna parte de estos términos, no podrá acceder a la plataforma.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">2. Uso de la Plataforma</h2>
            <p class="mb-4">
                La plataforma está diseñada para el uso exclusivo de estudiantes, docentes y personal autorizado de la Universidad de la Paz. El acceso y uso de los recursos educativos debe ser con fines académicos y de aprendizaje.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">3. Cuentas de Usuario</h2>
            <p class="mb-4">
                Los usuarios son responsables de mantener la confidencialidad de sus credenciales de acceso y de todas las actividades que ocurran bajo su cuenta. Debe notificar inmediatamente cualquier uso no autorizado de su cuenta.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">4. Contenido y Propiedad Intelectual</h2>
            <p class="mb-4">
                Todo el contenido disponible en la plataforma, incluyendo pero no limitado a textos, gráficos, logos, imágenes, clips de audio, descargas digitales y compilaciones de datos, es propiedad de la Universidad de la Paz o de sus proveedores de contenido y está protegido por las leyes de propiedad intelectual.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">5. Conducta del Usuario</h2>
            <p class="mb-4">
                Los usuarios deben:
            </p>
            <ul class="list-disc pl-6 mb-4">
                <li>Utilizar la plataforma de manera ética y responsable</li>
                <li>Respetar los derechos de propiedad intelectual</li>
                <li>No compartir contenido inapropiado o ofensivo</li>
                <li>No realizar actividades que puedan dañar o sobrecargar la plataforma</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">6. Modificaciones</h2>
            <p class="mb-4">
                La Universidad de la Paz se reserva el derecho de modificar estos términos y condiciones en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación en la plataforma.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">7. Limitación de Responsabilidad</h2>
            <p class="mb-4">
                La Universidad de la Paz no será responsable por daños indirectos, incidentales, especiales, consecuentes o punitivos que resulten del uso o la imposibilidad de usar la plataforma.
            </p>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">8. Contacto</h2>
            <p class="mb-4">
                Para cualquier consulta sobre estos términos y condiciones, por favor contacte a:
                <br>
                Email: soporte@unipaz.edu.co
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