<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProgramaAcademicoController;
use App\Http\Controllers\Docente\OvaController as DocenteOvaController;
use App\Http\Controllers\Docente\ActividadController as DocenteActividadController;
use App\Http\Controllers\Docente\EvaluacionFinalController as DocenteEvaluacionController;
use App\Http\Controllers\Estudiante\OvaController as EstudianteOvaController;
use App\Http\Controllers\Estudiante\EvaluacionController as EstudianteEvaluacionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EstudianteDashboardController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumThreadController;
use App\Http\Controllers\ForumReplyController;
use App\Http\Controllers\ForumThreadReactionController;
use App\Http\Controllers\RecursoActividadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas públicas (sin autenticación)
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/home', function () {
    return redirect()->route('login');
})->name('home.redirect');

Route::get('/legal', [LegalController::class, 'index'])->name('legal');

// Rutas de autenticación (login y registro)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Redirección basada en rol después de login
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDocente()) {
            return redirect()->route('docente.dashboard');
        } elseif ($user->isEstudiante()) {
            return redirect()->route('estudiante.dashboard');
        }
        return redirect()->route('login');
    })->name('dashboard');

    // Rutas del panel de administración
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Gestión de programas académicos
        Route::resource('programas', ProgramaAcademicoController::class);
        
        // Gestión de usuarios
        Route::resource('usuarios', UsuarioController::class);
        
        // Gestión de temas
        Route::resource('temas', TemaController::class);
        
        // Gestión de etiquetas
        Route::resource('etiquetas', EtiquetaController::class);
    });

    // Rutas del panel docente
    Route::middleware('role:docente')->prefix('docente')->name('docente.')->group(function () {
        Route::get('dashboard', [DocenteDashboardController::class, 'index'])->name('dashboard');
        
        // Gestión de OVAs
        Route::resource('ovas', DocenteOvaController::class);
        Route::post('ovas/{ova}/publicar', [DocenteOvaController::class, 'publicar'])->name('ovas.publicar');
        
        // Gestión de actividades
        Route::resource('ovas.actividades', DocenteActividadController::class);
        
        // Gestión de evaluaciones
        Route::resource('ovas.evaluaciones', DocenteEvaluacionController::class);
        
        // Gestión de recursos
        Route::resource('actividades.recursos', RecursoActividadController::class);
    });

    // Rutas del panel estudiante
    Route::middleware('role:estudiante')->prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', [EstudianteDashboardController::class, 'index'])->name('dashboard');
        Route::get('/ovas', [EstudianteOvaController::class, 'index'])->name('ovas.index');
        Route::get('/ovas/{ova}', [EstudianteOvaController::class, 'show'])->name('ovas.show');
        Route::get('/mis-ovas', [EstudianteOvaController::class, 'misOvas'])->name('mis-ovas');
        Route::get('/ovas/{ova}/actividades/{actividad}', [EstudianteActividadController::class, 'show'])->name('actividades.show');
        Route::post('/ovas/{ova}/actividades/{actividad}/progreso', [EstudianteActividadController::class, 'guardarProgreso'])->name('actividades.progreso');
        Route::post('/ovas/{ova}/actividades/{actividad}/evaluacion', [EstudianteActividadController::class, 'enviarEvaluacion'])->name('actividades.evaluacion');
        
        // Evaluaciones
        Route::get('ovas/{ova}/evaluaciones/{evaluacion}', [EstudianteEvaluacionController::class, 'show'])
            ->name('ovas.evaluaciones.show');
        Route::post('ovas/{ova}/evaluaciones/{evaluacion}/intento', [EstudianteEvaluacionController::class, 'registrarIntento'])
            ->name('ovas.evaluaciones.intento');
        
        // Foro
        Route::resource('ovas.foro', ForumThreadController::class)->shallow();
        Route::resource('ovas.foro.replies', ForumReplyController::class)->shallow();
        Route::post('foro/{thread}/reaccion', [ForumThreadReactionController::class, 'store'])
            ->name('foro.reaccion');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Rutas legales
Route::get('terminos-y-condiciones', [LegalController::class, 'terms'])->name('terms.show');
Route::get('politica-de-privacidad', [LegalController::class, 'privacy'])->name('privacy.show');
