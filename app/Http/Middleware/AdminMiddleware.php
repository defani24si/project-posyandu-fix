<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('auth')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah user adalah admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin yang dapat melakukan tindakan ini.');
        }

        return $next($request);
    }
}
