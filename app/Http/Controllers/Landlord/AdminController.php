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
