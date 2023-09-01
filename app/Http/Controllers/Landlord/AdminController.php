<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Language;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('landlord.super-admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }



    protected function authenticated(Request $request, $user)
    {
        if ($user->is_super_admin) {
            $language = Language::where('is_default',1)->first();
            Session::put('DefaultSuperAdminLangId', $language->id);
            Session::put('DefaultSuperAdminLocale', $language->locale);
            return redirect('/super-admin/dashboard');
        }
    }

    public function username()
	{
		return 'username';
	}


    public function logout(Request $request)
    {
        Session::forget(['TempSuperAdminLangId','DefaultSuperAdminLangId']);

        Auth::logout();

        return redirect('/super-admin');
    }
}
