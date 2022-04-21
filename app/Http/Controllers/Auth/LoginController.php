<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Flash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

    public function postLogin(Request $request)
    {
        $validatedData = [
            'email' => 'required',
            'password' => 'required',
        ];

        $validator = \Validator::make($request->all(), $validatedData);

        if ($validator->fails()) {
            $request->session()->flash('error', 'Field cannot be Empty');
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $backToLogin = redirect()->route('login')->withInput();
        $findUser = Sentinel::findByCredentials(['login' => $request->input('email')]);

        // If we can not find user based on email...
        if (! $findUser) {
//            flash()->error('Wrong email!');
            return $backToLogin->withErrors(['email' => 'These credentials do not match our records.']);
        }

        try {
            $remember = (bool) $request->input('remember_me');
            // If password is incorrect...
            if (! Sentinel::authenticate($request->all(), $remember)) {
//                flash()->error('Password is incorrect!');

                return $backToLogin->withErrors(['email' => 'These credentials do not match our records.']);
            }

//            flash()->success('Login success!');

            $role = null;

            if($findUser->roles->first()){
                $role = Sentinel::findRoleById($findUser->roles->first()->id);
            }

            if($role){
                if($role->slug == "super-admin"){
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('dashboard');
                }
            }else{
                Sentinel::logout();
                return $backToLogin->withErrors(['email' => 'These credentials not activated yet.']);
            }

        } catch (ThrottlingException $e) {
            flash()->error('Too many attempts!');
        } catch (NotActivatedException $e) {
            flash()->error('Please activate your account before trying to log in.');
        }

        return $backToLogin->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function forceLogout()
    {
        Sentinel::logout();
        flash()->success("Logout Success!");
        return redirect()->route('login');
    }
}
