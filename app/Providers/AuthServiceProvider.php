<?php

namespace App\Providers;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Fortify::authenticateUsing(function ($request) {
            if(str_contains($request->username,'@')){
                $arr=explode('@',$request->username);
                if($arr[1]!='mpu.edu.mo'){
                    return false;
                }
                $username=$arr[0];//substr($request->username,0,strpos($request->username,'@'));
            }else{
                $username=$request->username;
            }
            //$username=$request->username;
            $password=$request->password;
            config(['fortify.guard' => 'web']);
            Auth::shouldUse(config('fortify.guard'));
            $validated = Auth::validate([
                'username' => $username,
                'password' => $password
            ]);
            if(!$validated){
                //dd($username, $password);
                config(['fortify.username' => 'username']);
                config(['fortify.guard' => 'ldap_web']);
                Auth::shouldUse(config('fortify.guard'));
                $validated = Auth::validate([
                    'samaccountname' => $username,
                    'password' => $password
                ]);
                config(['fortify.guard' => 'web']);
                Auth::shouldUse(config('fortify.guard'));
            }
            return $validated ? Auth::getLastAttempted() : null;
        });

    }
}
