<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient;
use Laravel\Passport\Token;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::personalAccessClientId(1);
//
//        Passport::useTokenModel(Token::class);
//
//        Passport::useClientModel(Client::class);
//
//        Passport::useAuthCodeModel(AuthCode::class);
//
//        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
//
//        Passport::tokensExpireIn(now()->addMinutes(10));
//
//        Passport::refreshTokensExpireIn(now()->addMinutes(20));
//
//        Passport::personalAccessTokensExpireIn(now()->addMinutes(30));
    }
}
