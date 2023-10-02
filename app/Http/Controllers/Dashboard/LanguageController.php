<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware('client', ['only' => ['show']]);
        $this->middleware('admin', ['except' => ['show']]);
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $langs = Lang::orderBy('name')->paginate(10);
        return view('dashboard.lang.list', compact('langs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.lang.create');
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
            'name' => 'required',
            'code' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'default' => ($request->default) ? 1 : 0,
        ];

        if($request->default){
            foreach (Lang::all() as $item){
                $item->update(['default' => 0]);
            }
        }

        $lang = Lang::create($data);

        return redirect()->back()->with('success', 'Language added.');
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
    public function edit($id)
    {
        $lang = Lang::find($id);
        return view('dashboard.lang.edit', compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'default' => ($request->default) ? 1 : 0,
        ];

        if($request->default){
            foreach (Lang::all() as $item){
                $item->update(['default' => 0]);
            }
        }

        $lang = Lang::find($id);
        $lang = $lang->update($data);

        return redirect()->back()->with('success', 'Language updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lang = Lang::find($id);
        if($lang){
            $lang->delete();
        }
        $url =  url('') . '/dashboard/languages';
        return response()->json(['status' => 'deleted', 'url' => $url]);


    }
}
