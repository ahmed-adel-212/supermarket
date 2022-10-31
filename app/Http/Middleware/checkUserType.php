<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $type)
    {
        if (auth()->check() && auth()->user()->type === $type) {
            return $next($request);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('auth.unauthenticated'),
            ]);
        }

        return redirect(route('login'));
    }
}
