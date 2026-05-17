<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureViewerAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole(['viewer', 'super_admin'])) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه المنطقة.');
        }

        return $next($request);
    }
}
