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
            //dd(config('fortify.guard'),config('fortify.username'));
            $validated = Auth::validate([
                'username' => $request->username,
                'password' => $request->password
            ]);
            if(!$validated){
                config(['fortify.username' => 'username']);
                config(['fortify.guard' => 'ldap_web']);
                Auth::shouldUse(config('fortify.guard'));
                $validated = Auth::validate([
                    'samaccountname' => $request->username,
                    'password' => $request->password
                ]);
                config(['fortify.guard' => 'web']);
                Auth::shouldUse(config('fortify.guard'));
            }
            // $validated = Auth::validate([
            //     'samaccountname' => $request->username,
            //     'password' => $request->password
            // ]);


            return $validated ? Auth::getLastAttempted() : null;
        });

    }
}
