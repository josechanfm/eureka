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

            // if(str_contains($request->username,'@')){
            //     $username=substr($request->username,0,strpos($request->username,'@'));
            // }else{
            //     $username=$request->username;
            // }
            $username=$request->username;
            $password=$request->password;

            $validated = Auth::validate([
                'username' => $username,
                'password' => $password
            ]);
            if(!$validated){
                config(['fortify.username' => 'username']);
                config(['fortify.guard' => 'ldap_web']);
                Auth::shouldUse(config('fortify.guard'));
                $validated = Auth::validate([
                    'samaccountname' => 'josechan',
                    'password' => $password
                ]);
                dd($request->all(),$validated);
                config(['fortify.guard' => 'web']);
                Auth::shouldUse(config('fortify.guard'));
            }

            return $validated ? Auth::getLastAttempted() : null;
        });

    }
}
