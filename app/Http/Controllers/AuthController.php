<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Laravel
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Mail;
use Session;
use Validator;

// Mail
use App\Mail\ResetPasswordMail;

// Model
use App\User;

class AuthController extends Controller
{
    // =======================|                  |=======================  //
    // =======================|     REGISTER     |=======================  //
    // =======================|                  |=======================  //

    // GET
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // POST
    public function register(Request $request)
    {
        $validator = $this->validateRegister($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->except('password-confirmation'));
        }

        if ($this->attemptRegister($request)) {
            $this->attemptLogin($request);
            return redirect()->route('admin');
        } else {
            Session::flash('failure', trans('messages.session:failure-register'));
            return redirect()->back()->withInput($request->except('password'));
        }
    }

    // SELF
    private function validateRegister($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'email' => 'required|email|max:128|unique:users,email',
            'password' => 'required|string|min:8|max:16',
            'password-confirmation' => 'required|string|min:8|max:16|same:password',
        ]);
    }

    // SELF
    private function attemptRegister($request)
    {
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])->save();
    }

    // =======================|               |=======================  //
    // =======================|     LOGIN     |=======================  //
    // =======================|               |=======================  //

    // GET
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // POST
    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->except('password'));
        }

        if ($this->attemptLogin($request)) {
            return redirect()->route('admin');
        } else {
            Session::flash('failure', trans('messages.session:failure-login'));
            return redirect()->back()->withInput($request->except('password'));
        }
    }

    // SELF
    private function validateLogin($request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    // SELF
    private function attemptLogin($request)
    {
        $withRemember = isset($request['remember-me']) ? true : false;
        Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ], $withRemember);

        return Auth::check();
    }

    // =======================|                         |=======================  //
    // =======================|     FORGOT PASSWORD     |=======================  //
    // =======================|                         |=======================  //

    // GET
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // POST
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('password_resets')->where('email', $request['email'])->delete();

        $token = Hash::make(Carbon::now()->format('dmyHis') . str_shuffle($request['email']));

        DB::table('password_resets')->updateOrInsert([
            'email' => $request['email'],
        ], [
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $user = [
            'email' => $request['email'],
        ];

        $data = [
            'email' => $request['email'],
            'token' => $token,
        ];

        try {
            Mail::to($user['email'])->send(new ResetPasswordMail($data));
            if (count(Mail::failures()) > 0) {
                Session::flash('mail-failure', trans('messages.session:failure-mail-submission'));
            } else {
                Session::flash('success', trans('messages.session:success-forgot-password'));
            }
        } catch (\Throwable $th) {
            Session::flash('mail-service-error', trans('messages.session:service-error-mail-submission'));
        }

        return redirect()->back();
    }

    // GET
    public function showResetPasswordForm(Request $request)
    {
        $parsedToken = base64_decode($request['token']);
        $password_reset = collect(DB::table('password_resets')->where('email', $request['email'])->where('token', $parsedToken)->first());

        if ($password_reset->isEmpty()) {
            abort(404);
        } else {
            $data = [
                'email' => $request['email'],
                'token' => $parsedToken,
            ];
            return view('auth.reset-password', compact('data'));
        }
    }

    // POST
    public function resetPassword(Request $request)
    {
        $regex = 'regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/';
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:16|'.$regex,
            'password-confirmation' => 'required|string|'.$regex.'|same:password',
            'token' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request['email'])->first();

        $user['password'] = Hash::make($request['password']);

        if ($user->save()) {
            DB::table('password_resets')->where('email', $request['email'])->delete();

            Auth::login($user);
            return redirect()->route('admin');
        } else {
            Session::flash('failure', trans('messages.session:failure-server-error'));
            return redirect()->back();
        }
    }

    // =======================|                |=======================  //
    // =======================|     LOGOUT     |=======================  //
    // =======================|                |=======================  //

    // POST
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
