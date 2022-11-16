<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            if(Auth::check()) {
                return redirect()->route('dashboard.index');
            } else {
                return view('admin.pages.login');
            }
        }

        $credentials = $request->only(['username', 'password']);
        if (Auth::attempt($credentials, $request->remember_me == 'on')) {
            $user = Auth::user();
            Log::alert('[LOGIN] by ' . $user->name . '{"id":' . $user->id . ', "username":"' . $user->username . '", "status":"success"}');
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->back()->withInput($request->input())->withErrors(['message' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
        }
    }

    public function logout()
    {
        Auth::logout();
        // $cookie = Cookie::forget('user_name');->withCookie($cookie)
        return redirect()->route('login');
    }
}
