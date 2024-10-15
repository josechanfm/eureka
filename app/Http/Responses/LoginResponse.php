<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {

        //$pageRoute=config('fortify.home');
        $pageRoute='staff/dashboard';
        //dd($pageRoute);
        if(auth()->user()->roles->count()>0){
            $pageRoute='admin/dashboard';
        };

        
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended($pageRoute);
    }
}