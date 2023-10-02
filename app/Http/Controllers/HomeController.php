<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Iso;
use App\Models\Lang;
use App\Models\Method;
use App\Models\Slide;
use App\Models\Text;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $standards = Iso::get();
        $slides = Slide::get();
        $advantages = Advantage::get();
        $methods = Method::orderBy('number')->get();
        $texts = Text::get();
        $texts = !empty($texts) ? $texts[0] : [];
        return view('home', compact('standards', 'texts', 'slides', 'methods', 'advantages'));
    }


    public function switchLang($code){
        $lang = Lang::where('code', $code)->first();


        if($lang){
            if(Auth::user()){
                $user = User::find(Auth::id());
                $user->lang = $code;
                $user->save();
            }else{
                session()->put('locale', $code);
            }
        }

        return redirect()->back();
    }
}
