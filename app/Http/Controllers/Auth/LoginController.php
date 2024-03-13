<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Please fill in the username first',
                'password.required' => 'Please fill in the password first'
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $credentials = $request->only('username', 'password');
            $user = User::where(function ($query) use ($credentials) {
                $query->where('email', $credentials['username'])
                    ->orWhere('phone_number', $credentials['username']);
            })
                ->first();

            if (!$user) {
                return response()->json(['NoUsername' => ['message' => 'Username not found.']]);
            }

            if ($user->active_status == 1) {
                return response()->json(['NonActiveUsername' => ['message' => 'Your account has been deactivated.']]);
            }

            if ($user && Hash::check($credentials['password'], $user->password)) {
                Auth::loginUsingId($user->id);
                if ($user->type == 'Administrator') {
                    return response()->json(['redirect' => route('dashboard.index')]);
                } elseif ($user->type == 'User') {
                    return response()->json(['redirect' => route('dashboard.index')]);
                }
            } else {
                return response()->json(['WrongPassword' => ['message' => 'Wrong password.']]);
            }
        }
    }


    public function username()
    {
        $fieldType = filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        request()->merge([$fieldType => request('username')]);
        return $fieldType;
    }
}
