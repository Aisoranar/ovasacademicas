<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Ova;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Models\EvaluacionFinal;
use App\Policies\OvaPolicy;
use App\Policies\ForumThreadPolicy;
use App\Policies\ForumReplyPolicy;
use App\Policies\EvaluacionFinalPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Ova::class => OvaPolicy::class,
        ForumThread::class => ForumThreadPolicy::class,
        ForumReply::class => ForumReplyPolicy::class,
        EvaluacionFinal::class => EvaluacionFinalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar si el usuario es administrador
        Gate::define('is-admin', function ($user) {
            return $user->rol === 'admin';
        });

        // Gate para verificar si el usuario es docente
        Gate::define('is-docente', function ($user) {
            return $user->rol === 'docente';
        });

        // Gate para verificar si el usuario es estudiante
        Gate::define('is-estudiante', function ($user) {
            return $user->rol === 'estudiante';
        });

        // Gate para verificar si el usuario es docente de un OVA específico
        Gate::define('is-ova-docente', function ($user, $ova) {
            return $user->rol === 'docente' && $user->id === $ova->docente_id;
        });

        // Gate para verificar si el usuario pertenece al programa académico de un OVA
        Gate::define('belongs-to-ova-program', function ($user, $ova) {
            return $user->programa_academico_id === $ova->programa_academico_id;
        });
    }
}
