<?php

namespace App\Http\Middleware;
use JWTFactory;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {   
        $user = JWTAuth::user();

        $user = $user->load('roles');

        foreach( $roles as $role ) {
          if( $user->hasRole($role) )
            return $next($request);
        } 

        return response()->json([
            'StatusCode' => '500',
            'message' => 'Not authorized',
            'result' => new \stdClass
        ]);
    }
}
