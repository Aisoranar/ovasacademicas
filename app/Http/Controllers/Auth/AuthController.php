<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->rol === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->rol === 'docente') {
                return redirect()->route('docente.dashboard');
            } else {
                return redirect()->route('estudiante.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'identificacion' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'rol' => ['required', 'in:estudiante,docente'],
            'programa_academico' => ['required_if:rol,estudiante'],
            'departamento_academico' => ['required_if:rol,docente'],
        ]);

        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            'identificacion' => $request->identificacion,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'programa_academico' => $request->programa_academico,
            'departamento_academico' => $request->departamento_academico,
            'tipo_registro' => 'email'
        ]);

        Auth::login($user);

        if ($user->rol === 'docente') {
            return redirect()->route('docente.dashboard');
        } else {
            return redirect()->route('estudiante.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
} 