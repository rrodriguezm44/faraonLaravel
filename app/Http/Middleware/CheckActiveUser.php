<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
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
        // Si el usuario está autenticado
        if (Auth::check()) {
            // Verificar si el usuario está activo
            if (!Auth::user()->is_active) {
                // Desconectar al usuario inactivo
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/admin/login')
                    ->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
            }
        }

        return $next($request);
    }
}
