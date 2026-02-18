<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProbeCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // هيدر للتأكد أن الميدلوير اشتغلت
        $response->headers->set('X-Probe-MW', '1');

        // كوكي "قسرية" لا علاقة لها بالـ session
        return $response->cookie('probe_cookie', '1', 5);
    }
}
