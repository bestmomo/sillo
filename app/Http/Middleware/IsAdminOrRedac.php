<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrRedac
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
	 */
	public function handle(Request $request, \Closure $next): Response
	{
		if (!auth()->user()->isAdmin() && !auth()->user()->isRedac()) {
			abort(403);
		}

		return $next($request);
	}
}
