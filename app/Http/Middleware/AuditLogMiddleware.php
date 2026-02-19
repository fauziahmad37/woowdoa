<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditLogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // contoh sederhana
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'model' => 'Request',
            'action' => $request->method(),
            'new_data' => $request->all(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $next($request);
    }
}
