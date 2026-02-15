<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $adminKey = config('app.admin_key', env('ADMIN_KEY', 'boteshoy-admin-2024'));
        
        // Verificar clave en query string o en sesión
        if ($request->query('key') === $adminKey) {
            session(['admin_authenticated' => true]);
        }
        
        if (!session('admin_authenticated')) {
            abort(404); // Simular que no existe
        }
        
        return $next($request);
    }
}
