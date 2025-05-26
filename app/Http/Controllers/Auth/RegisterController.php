<?php
// File: app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProgramaAcademico;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $programasAcademicos = ProgramaAcademico::where('estado', true)->get();
        $departamentosAcademicos = User::getEnumValues('departamento_academico');
        $roles = User::getEnumValues('rol');

        return view('auth.register', compact('programasAcademicos', 'departamentosAcademicos', 'roles'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'identificacion' => ['required', 'string', 'max:20', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rol' => ['required', 'string', 'in:' . implode(',', User::getEnumValues('rol'))],
            'programa_id' => ['required_if:rol,estudiante', 'exists:programas_academicos,id'],
            'departamento_academico' => ['required', 'string', 'in:' . implode(',', User::getEnumValues('departamento_academico'))],
            'semestre_actual' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'nombre_completo' => $data['name'],
            'identificacion' => $data['identificacion'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => $data['rol'],
            'programa_id' => $data['programa_id'] ?? null,
            'departamento_academico' => $data['departamento_academico'],
            'semestre_actual' => $data['semestre_actual'] ?? null,
            'tipo_registro' => 'email',
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                    ?: redirect($this->redirectPath());
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function registered(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDocente()) {
            return redirect()->route('docente.dashboard');
        }

        return redirect()->route('estudiante.dashboard');
    }
}


