<?php

namespace App\Http\Middleware;

use Brryfrmnn\Transformers\Json;
use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role_id)
    {
        $user = $request->user();
        if ($user->role_id !== $role_id) {
            return Json::response("Anda Tidak Memiliki Akses");
        }
        return $next($request);
        
    }
}
