<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index()
    {
        $texts = Text::first();
        return view('dashboard.texts', compact('texts'));
    }

    public function store(Request $request)
    {
        $text = Text::first();
        if(!$text)
            $text = new Text();


        foreach (Lang::all() as $key => $lang){
            $text->setTranslation('intro', $lang->code, $request->intro[$lang->code]);
            $text->setTranslation('slider', $lang->code, $request->slider[$lang->code]);
            $text->setTranslation('oms_title', $lang->code, $request->oms_title[$lang->code]);
            $text->setTranslation('oms', $lang->code, $request->oms[$lang->code]);
            $text->setTranslation('method_title', $lang->code, $request->method_title[$lang->code]);
            $text->setTranslation('method_subtitle', $lang->code, $request->method_subtitle[$lang->code]);
            $text->setTranslation('mission_title', $lang->code, $request->mission_title[$lang->code]);
            $text->setTranslation('mission', $lang->code, $request->mission[$lang->code]);
            $text->setTranslation('iso', $lang->code, $request->iso[$lang->code]);
            $text->setTranslation('about', $lang->code, $request->about[$lang->code]);
            $text->setTranslation('details', $lang->code, $request->details[$lang->code]);
        }


        $text->save();
        return redirect()->back()->with('success', 'Content texts successfully updated.');
    }
}
