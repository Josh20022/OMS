<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Method;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $methods = Method::orderBy('number')->get();
        return view('dashboard.content.methodsList', compact('methods'));
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
            'number' => 'required|unique:methods'
        ]);

        $method = new Method();
        $method->number = $request->number;
        foreach (Lang::all() as $key => $lang){
            $method->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $method->setTranslation('description', $lang->code, $request->description[$lang->code]);
        }
        $method->save();

        return redirect()->back()->with('success', 'Method added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function show(Method $method)
    {
        return view('dashboard.content.methodShow', compact('method'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function edit(Method $method)
    {
        return view('dashboard.content.methodEdit', compact('method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Method $method)
    {
        $request->validate([
            'number' => [
                'required',
                Rule::unique('methods')->ignore($method->id),
            ],
            'title' => 'required',
            'description' => 'required',
        ]);


        $method->number = $request->number;
        foreach (Lang::all() as $key => $lang){
            $method->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $method->setTranslation('description', $lang->code, $request->description[$lang->code]);
        }
        $method->save();

        return redirect()->route('methods.index')->with('success', 'Method updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy(Method $method)
    {
        $method->delete();
        $url =  url('') . '/dashboard/methods';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }
}
