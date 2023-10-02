<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contactEmail(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if($validation->fails()) return redirect(url()->previous() . "#contact")->withErrors($validation->errors());
        Mail::to('info@we-management.com')->send(new ContactMail($request->name, $request->email, $request->message));
        return redirect(url()->previous() . "#contact")->with('success', 'Thank you for your message!');
    }
}
