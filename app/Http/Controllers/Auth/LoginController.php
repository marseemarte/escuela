<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Personas\Persona;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-custom');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        Log::info('Intento de login:', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        // Buscar usuario por email/mail
        $persona = Persona::where('mail', $request->email)->first();

        if (!$persona) {
            Log::warning('Usuario no encontrado:', ['email' => $request->email]);
            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        Log::info('Usuario encontrado:', [
            'nombre' => $persona->nombre,
            'apellido' => $persona->apellido,
            'dni' => $persona->dni
        ]);

        // Verificar contraseña
        if (!Hash::check($request->password, $persona->pass)) {
            Log::warning('Contraseña incorrecta para usuario:', [
                'email' => $request->email,
                'usuario_id' => $persona->id,
                'password_provided' => $request->password,
                'password_hash_stored' => $persona->pass
            ]);
            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        Log::info('Contraseña verificada correctamente. Intentando login...');

        // Autenticar usuario
        Auth::login($persona, $request->filled('remember'));

        Log::info('Login exitoso:', [
            'usuario_id' => $persona->id,
            'email' => $persona->mail,
            'auth_check_after_login' => Auth::check(),
            'auth_user_after_login' => Auth::user() ? Auth::user()->id : 'null',
            'auth_identifier' => $persona->getAuthIdentifier(),
            'auth_identifier_name' => $persona->getAuthIdentifierName(),
            'session_id_before_regenerate' => $request->session()->getId()
        ]);

        // NO regenerar sesión inmediatamente, puede causar problemas
        // $request->session()->regenerate();

        Log::info('Preparando redirección:', [
            'auth_check_before_redirect' => Auth::check(),
            'auth_user_before_redirect' => Auth::user() ? Auth::user()->id : 'null',
            'intended_route' => route('dashboard')
        ]);

        return redirect()->intended(route('dashboard'));
    }
}
