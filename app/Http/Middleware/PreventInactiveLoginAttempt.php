<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventInactiveLoginAttempt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');

            // Intentar autenticar con las credenciales proporcionadas
            if (Auth::attempt($credentials)) {
                // Verificar si el usuario está activo
                if (!Auth::user()->is_active) {
                    // Desconectar al usuario inactivo
                    Auth::logout();
                    $request->session()->invalidate();

                    return redirect('/admin/login')
                        ->withInput($request->only('email'))
                        ->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
                }
            }
        }

        return $next($request);
    }
}
