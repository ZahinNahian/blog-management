<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email=$request->session()->get('email', 'default');
        $user_id=$request->session()->get('user_id', 'default');
        if ($email=='default') {
            return redirect('/');
        } else {
            $request->headers->set('email', $email);
            $request->headers->set('id', $user_id);
            return $next($request);
        }
        
    }
}
