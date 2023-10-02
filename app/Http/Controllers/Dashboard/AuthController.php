<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MikeMcLin\WpPassword\Facades\WpPassword;

class AuthController extends Controller
{

    public function authForm()
    {
        return view('dashboard.login');
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

        if($user && Auth::user()->type == 'admin') {
            return redirect()->route('dashboard');
        } else {
            $user = User::where('email', $request->email)->first();
            if($user && $user->type == 'admin') {
                if(WpPassword::check($request->password, $user->password)) {
                    Auth::login($user);
                    Auth::user()->update(['password' => Hash::make($request->password)]);
                    return redirect()->route('dashboard');
                }
            }
        }

        return back()->with('error', 'Incorrect email or password.');
    }

}
