<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Models\Lang;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advantages = Advantage::get();
        return view('dashboard.content.advantagesList', compact('advantages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required'
        ]);

        $advantage = new Advantage();
        $advantage->icon = $request->icon;
        foreach (Lang::all() as $key => $lang){
            $advantage->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $advantage->setTranslation('description', $lang->code, $request->description[$lang->code]);
        }
        $advantage->save();

        return redirect()->back()->with('success', 'Advantage added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advantage  $advantage
     * @return \Illuminate\Http\Response
     */
    public function show(Advantage $advantage)
    {
        return view('dashboard.content.advantageShow', compact('advantage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advantage  $advantage
     * @return \Illuminate\Http\Response
     */
    public function edit(Advantage $advantage)
    {
        return view('dashboard.content.advantageEdit', compact('advantage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advantage  $advantage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advantage $advantage)
    {
        $request->validate([
            'icon' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);


        $advantage->icon = $request->icon;
        foreach (Lang::all() as $key => $lang){
            $advantage->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $advantage->setTranslation('description', $lang->code, $request->description[$lang->code]);
        }
        $advantage->save();

        return redirect()->route('advantages.index')->with('success', 'Advantage updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advantage  $advantage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advantage $advantage)
    {
        $advantage->delete();
        $url =  url('') . '/dashboard/advantages';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }
}
