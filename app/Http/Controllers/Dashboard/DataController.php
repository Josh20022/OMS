<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Form;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
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
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Data $data)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(Data $data)
    {
        $users = auth()->user()->children->pluck('id')->toArray();
        $users[] = auth()->id();

        if(!auth()->user()->isAdmin() && !in_array($data->user_id, $users)) abort('404');

        $root = getProtocol() . getDomain() . '/media/' . $data->user_id . '/';
        $form = Form::find($data->form_id);
        $template = json_decode($form->template, true);
        $formData = $hiddenFields = [];

        foreach($data->data as $d) $formData[$d['name']] = $d;

        foreach($template as $key => $value) {
            if(!isset($formData[$value['name']])) continue;
            $val = $formData[$value['name']]['value'];
            if($val === 'N/A') continue;

            if($value['type'] === 'file') {
                $hiddenFields[] = [
                    "type" => "hidden",
                    "name" => "hidden-field-" . $formData[$value['name']]['name'],
                    "userData" => [json_encode($val)],
                    "access" => false
                ];

                continue;
            }

            $template[$key]['userData'] = is_array($val) ? $val : [$val];
        }

        $template = array_merge($template, $hiddenFields);
        return view('dashboard.data.edit', compact('template', 'data', 'root'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        $submittedData = $request->all();

        foreach($request->files as $field => $file) {
            if(is_array($file)) {
                $uploadedData = [];
                foreach($request->file($field) as $singleFile) $uploadedData[] = $this->upload($singleFile, $data->user_id);
                $submittedData[$field] = $uploadedData;
            } else {
                $submittedData[$field] = $this->upload($request->file($field), $data->user_id);
            }
        }

        if(isset($submittedData['_token'])) unset($submittedData['_token']);
        if(isset($submittedData['_method'])) unset($submittedData['_method']);

        foreach($submittedData as $key => $value) {
            if(str_contains($key, 'hidden-field-')) {
                $newKey = str_replace('hidden-field-', '', $key);
                $hiddenData = json_decode($value, true);
                if(isset($submittedData[$newKey])) $hiddenData = array_merge(is_array($hiddenData) ? $hiddenData : [], is_array($submittedData[$newKey]) ? $submittedData[$newKey] : [$submittedData[$newKey]]);
                $submittedData[$newKey] = $hiddenData;
                unset($submittedData[$key]);
            }
        }

        $data->data = json_encode($submittedData);
        $data->save();
        return redirect()->route('forms.show', $data->form_id)->with('success', 'Data updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        $data->delete();
        $url =  url('') . '/dashboard/forms/' . $data->form_id;
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }

    private function upload($file, $userId)
    {
        $media = $file->store($userId, 'local');
        return basename($media);
    }


}
