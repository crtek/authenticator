<?php namespace Crtek\Authenticator;

use Illuminate\Support\ServiceProvider;

class AuthenticatorServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot(\Illuminate\Contracts\Http\Kernel $kernel, \Illuminate\Routing\Router $router)
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'Authenticator');

        $this->publishes([
            __DIR__.'/Config/Authenticator.php' => config_path('Authenticator.php'),
            __DIR__.'/Views' => base_path('resources/views/Crtek/Authenticator'),
            __DIR__.'/Migrations' => base_path('database/migrations'),
        ]);

        $this->app->config->set('auth.model', $this->app->config->get('Authenticator.model'));

        include __DIR__.'/routes.php';

        //$kernel->prependMiddleware('Sheepy85\L5Localization\Middleware\Localization'); // prependMiddleware works too.
        $router->middleware('jwtAuth', 'Tymon\JWTAuth\Middleware\GetUserFromToken');
        $router->middleware('jwtRefresh', 'Tymon\JWTAuth\Middleware\RefreshToken');
    }

    public function register()
    {
        $this->app->bind('authenticator', function($app)
        {
            return $app->make('Crtek\Authenticator\AuthenticatorManager');
        });
        $this->registerSocialite();
        $this->registerUserModel();
        $this->registerJWTAuth();
    }

    public function registerSocialite()
    {
        $this->app->register('\Laravel\Socialite\SocialiteServiceProvider');
    }

    public function registerJWTAuth()
    {
        $this->app->register('Tymon\JWTAuth\Providers\JWTAuthServiceProvider');
    }

    public function registerUserModel()
    {
        $this->app->make('Crtek\Authenticator\Models\User');
    }

    public function provides()
    {
        return [
            'Crtek\Authenticator\AuthenticatorManager',
            '\Laravel\Socialite\SocialiteServiceProvider',
            'Tymon\JWTAuth\Providers\JWTAuthServiceProvider',
        ];
    }
}