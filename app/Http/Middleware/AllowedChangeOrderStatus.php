<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowedChangeOrderStatus
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->user()->id === request()->route('order')->user_id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
