<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekTipeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
// Cek apakah parameter 'type' di URL bernilai 'vip'
if ($request->query('type') !== 'vip') {
// Jika bukan VIP, kembalikan ke home dengan pesan error
return redirect('/')->with('success', 'Akses Ditolak: Fitur ini hanya
untuk pengguna VIP!');
}
return $next($request);
}
}
