<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordForm()
    {
        return view('forgotPassword');
    }

    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::to($request->email)->send(new ForgotPasswordMail($token));
        return back()->with('success', 'Check your email for password reset link.');
    }

    public function resetPasswordForm($token)
    {
        return view('resetPassword', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $updatePassword = DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token,
            ])->first();

        if(!$updatePassword) return back()->with('error', 'Invalid token.');

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect()->route('user.login.form')->with('success', 'Your password has been changed.');
    }
}
