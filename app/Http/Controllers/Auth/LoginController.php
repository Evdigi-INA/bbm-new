<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

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


    use AuthenticatesUsers {
        logout as preformlogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->preformlogout($request);
        return redirect()->route('login');
    }

    // custom redirect sesuai role setelah login
    protected function authenticated(Request $request, $user)
    {
        if ($user->getRoleNames()[0] == 'salesman') {
            return redirect()->route('direct-penjualan.create');
        }

        return redirect()->route('dashboard.index');
    }

    protected function validateLogin(Request $request)
    {
        // Get the user details from database and check if user is exist and active.
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status === 0) {
            throw ValidationException::withMessages([$this->username() => __('User has been desactivated.')]);
        }

        // Then, validate input.
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
