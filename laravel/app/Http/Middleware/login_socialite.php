<?php

namespace App\Http\Middleware;

use Closure;

class login_socialite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Socialite::driver('facebook')->userFromToken($request->token);

         if ($user->getName()) {
           return $next($request);
         }
         return redirect('some_other_route_for_error');     
        // return $next($request);
    }
}
