<?php

namespace App\Http\Middleware;

use App\Models\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_if($request->user()->role_id != RoleEnum::ADMINISTRATOR, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
