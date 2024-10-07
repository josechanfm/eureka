<?php
 
namespace App\Http\Middleware;
 
use Closure;
 
class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // I'm using the api guard
        $role = strtolower( request()->user()->type );
        $allowed_roles = array_slice(func_get_args(), 2);

        if( in_array($role, $allowed_roles) ) {
            return $next($request);
        }

        throw new AuthenticationException();
        //return $next($request);
    }
 
}