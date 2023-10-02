<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;
use Spatie\TranslationLoader\TranslationLoaders\Db;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;

class TranslationController extends Controller
{

    public function __construct()
    {
        $this->middleware('client', ['only' => ['show']]);
        $this->middleware('admin', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {
        $translations = LanguageLine::orderBY('id', 'desc')->get();
        return view('dashboard.translations.list', compact('translations', 'code'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($code)
    {
        return view('dashboard.translations.create', compact('code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($code, Request $request)
    {
        $request->validate([
            'key' => 'required',
            'text' => 'required'
        ]);

       $line =  LanguageLine::where('key', $request->key)->first();
       if($line){
           $translations = $line->text;
           $translations[$code] = $request->text;
           $line->text = $translations;
           $line->save();
       }else{
           LanguageLine::create([
               'group' => '',
               'key' => $request->key,
               'text' => [$code => $request->text],
           ]);
       }

        return redirect('dashboard/'.$code.'/translations')->with('success', 'Translation added.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($code, $id)
    {
        $lang = LanguageLine::find($id);
        return view('dashboard.translations.edit', compact('lang', 'code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($code, Request $request, $id)
    {
        $request->validate([
            'key' => 'required',
            'text' => 'required'
        ]);

        $line =  LanguageLine::where('key', $request->key)->first();
        if($line){
            $translations = $line->text;
            $translations[$code] = $request->text;
            $line->text = $translations;
            $line->save();
        }else{
            LanguageLine::create([
                'group' => '',
                'key' => $request->key,
                'text' => [$code => $request->text],
            ]);
        }

        return redirect('dashboard/'.$code.'/translations')->with('success', 'Translation updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
