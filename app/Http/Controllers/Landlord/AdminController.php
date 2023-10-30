<?php

namespace App\Http\Controllers\Landlord;

use App\Facades\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Landlord\Language;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


    public function profile()
    {
        $user = auth()->user();
        return view('landlord.super-admin.pages.profiles.index',compact('user'));
    }


    public function profileUpdate(UpdateProfileRequest $request, User $user)
    {
        try {
            $imageName = Utility::imageFileStore($request->profile_photo, 'landlord/images/profile/', 300, 200);
            $validatedData = $request->validated();
            $validatedData['profile_photo'] = $imageName;
            $user->update($validatedData);

            return redirect()->back()->with(['success' => 'Profile Updated Successfully']);

        } catch (Exception $e) {

            return redirect()->back()->withErrors(['errors' => [$e->getMessage()]]);
        }
    }

    public function passwordUpdate(UpdatePasswordRequest $request, User $user)
    {
        try {
            $user->password = Hash::make($request->password);
            $user->update();

            return redirect()->back()->with(['success' => 'Password Updated Successfully']);
        }
        catch (Exception $e) {

            return redirect()->back()->withErrors(['errors' => [$e->getMessage()]]);
        }
    }
}
