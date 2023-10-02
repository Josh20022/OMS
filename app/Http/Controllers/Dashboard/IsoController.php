<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Iso;
use App\Models\Lang;
use Illuminate\Http\Request;

class IsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $standards = Iso::orderBy('title')->paginate(10);
        return view('dashboard.content.isoList', compact('standards'));
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
            'title' => 'required',
            'content' => 'required',
        ]);


        $iso = new Iso();
        foreach (Lang::all() as $key => $lang){
            $iso->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $iso->setTranslation('content', $lang->code, $request->content[$lang->code]);
        }
        $iso->save();

        return redirect()->back()->with('success', 'ISO standard added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iso  $iso
     * @return \Illuminate\Http\Response
     */
    public function show(Iso $iso)
    {
        return view('dashboard.content.isoShow', compact('iso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iso  $iso
     * @return \Illuminate\Http\Response
     */
    public function edit(Iso $iso)
    {
        return view('dashboard.content.isoEdit', compact('iso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iso  $iso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iso $iso)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        foreach (Lang::all() as $key => $lang){
            $iso->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $iso->setTranslation('content', $lang->code, $request->content[$lang->code]);
        }
        $iso->save();


        return redirect()->route('isos.index')->with('success', 'ISO info updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iso  $iso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iso $iso)
    {
        $iso->delete();
        $url =  url('') . '/dashboard/isos';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }
}
