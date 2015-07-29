<?php namespace Crtek\Authenticator;

use Crtek\Authenticator\Repositories\UserRepository as Users;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Session;
//crtek
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory as JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authentication extends AuthenticatorManager {

    public $socialite;

    public $auth;

    public $users;

    public function __construct(Socialite $socialite, Guard $auth, Users $users) {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
    }

    public function execute($request = null, $provider, $stateless = false) {
        if (!$request) return $this->getAuthorizationFirst($provider, $stateless);
        $user = $this->users->findByUserNameOrCreate($this->getSocialUser($provider, $stateless, $request), $provider);

        if(!$user) {
            return redirect(config('Authenticator.login_page'))->with('session', 'Email is already in use');
        }

        (config('Authenticator.flash_session')) ?:
            Session::flash(
                config('Authenticator.flash_session_key'),
                config('Authenticator.flash_session_login')
            );
        $this->auth->login($user, true);

        return $this->userHasLoggedIn($user, $stateless);
    }

    private function getAuthorizationFirst($provider, $stateless = false) {
        if($stateless) {
            //return $this->socialite->driver($provider)->stateless()->redirect();
            return response()->json(array('Error' => 'You should login first.'), 401);
        }
        return $this->socialite->driver($provider)->redirect();
    }

    private function getSocialUser($provider, $stateless = false, $request = false) {
        if($stateless) {
            return $this->socialite->driver($provider)->stateless()->user();
        }
        return $this->socialite->driver($provider)->user();
    }

    public function userHasLoggedIn($user, $stateless = false) {
        if($stateless) {
            $token = JWTAuth::fromUser($user);
            return response()->json(array('token' => $token, 'crtek' => 'crtek')); 
        }
        return redirect(config('Authenticator.login_redirect'));
    }
}