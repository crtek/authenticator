<?php namespace Crtek\Authenticator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Crtek\Authenticator\Traits\AuthenticatesAndRegistersUsers;
use Crtek\Authenticator\Models\User;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Session;
use Auth;

class AuthController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, DispatchesCommands, ValidatesRequests;


    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function accountIsActive($code) {
        $user = User::where('activation_code', '=', $code)->first();
        if($user){
            $user->active = 1;
            $user->activation_code = '';
            if($user->save()) {
                Session::flash('message', 'Your account has been activated. You can login now!');
                return redirect(config('Authenticator.login_page'));
                //Auth::loginUsingId($user->id);
            }
        }else{
            return redirect('auth/register/')
            ->withErrors([
                'email' => 'Please create a valid account to login.'
            ]);
        }
    }

}
