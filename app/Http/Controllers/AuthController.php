<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Admin as AdminModel;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminsLoginGet()
    {
        if(Auth::guard('admins')->check()){
            return redirect()->route('admin.dashboard.home');
        }
        return view('auth.admins.login');
    }

    public function adminsloginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember_me = $request->has('remember_me') ?? false;

        if (Auth::guard('admins')->attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard.home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function usersLoginGet()
    {
        if (Auth::guard('users')->check()) {
            return redirect()->route('users.dashboard.home');
        }

        return view('auth.users.login');
    }

    public function usersLoginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember_me = $request->has('remember_me') ?? false;

        if (Auth::guard('users')->attempt($credentials, $remember_me)) {
            $request->session()->regenerate();
            return redirect()->route('users.dashboard.home');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request , $userType)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::guard($userType.'s')->logout();
    }

    public function redirectAfterLogout(Request $request, $userType)
    {
        $this->logout($request , $userType);
        if ($userType === Roles::ADMIN->value) {
            return redirect()->route('auth.admin.login');
        } elseif ($userType === Roles::USER->value) {
            return redirect()->route('auth.user.login');
        }
    }

    public function adminLogout(Request $request)
    {
        return $this->redirectAfterLogout($request, Roles::ADMIN->value);
    }

    public function userLogout(Request $request)
    {
        return $this->redirectAfterLogout($request, Roles::USER->value);
    }



    /**
     * Display the admin account recovery page
     *
     */
    public function adminAccountRecoveryGet()  {
        return view('auth.admins.password-recovery');
    }


    public function adminAccountRecoveryPost(Request $request) {
        $email = $request->input('email');

        $user = AdminModel::where('email',$email)->firstOrFail();

    }


    /**
     * Display the user account recovery page
     *
     */
    public function userAccountRecoveryGet()
    {
        return view('auth.users.password-recovery');
    }


    public function userAccountRecoveryPost(Request $request)
    {
        $email = $request->input('email');

        $user = UserModel::where('email', $email)->firstOrFail();

        return 'success';
    }

}
