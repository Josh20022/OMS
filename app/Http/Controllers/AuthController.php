<?php

namespace App\Http\Controllers;

use App\Models\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MikeMcLin\WpPassword\Facades\WpPassword;

class
AuthController extends Controller
{
    public function authForm()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if($user) {
            return redirect()->away( getProtocol() . Auth::user()->subdomain . '.' . getDomain() . '/profile');
        } else {
            $user = User::where('email', $request->email)->first();
            if($user) {
                if(WpPassword::check($request->password, $user->password)) {
                    Auth::login($user);
                    Auth::user()->update(['password' => Hash::make($request->password)]);
                    return redirect()->away( getProtocol() . Auth::user()->subdomain . '.' . getDomain() . '/profile');
                }
            }
        }

        return back()->with('error', 'Incorrect email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
