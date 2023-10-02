<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Models\Lang;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = Slide::paginate(10);
        return view('dashboard.content.slidesList', compact('slides'));
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
        $request->validate(['image' => 'required|image']);
        $data = ['description' => $request->description];

        if($request->hasFile('image')) {
            $folder = date('Y-m');
            $data['image'] = $request->file('image')->store("{$folder}");
        }


        $slide = new Slide();
        $slide->image = $data['image'];
        foreach (Lang::all() as $key => $lang){
            $slide->setTranslation('description', $lang->code, $request->description[$lang->code]);
        }
        $slide->save();

        return redirect()->back()->with('success', 'Slide added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('dashboard.content.slideEdit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $data = ['description' => $request->description];
        if($request->hasFile('image')) {
            Storage::delete($slide->image);
            $folder = date('Y-m');
            $data['image'] = $request->file('image')->store("{$folder}");
        }

        if( isset($data['image'])){
            $slide->image = $data['image'];
        }
        foreach (Lang::all() as $key => $lang){
            $slide->setTranslation('description', $lang->code, $request->description[$lang->code]);
        }

        $slide->save();
        return redirect()->route('slides.index')->with('success', 'Slide updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();
        Storage::delete($slide->image);
        $url =  url('') . '/dashboard/slides';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }
}
