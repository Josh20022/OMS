<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index($subdomain, $id)
    {
        $forms = auth()->user()->forms->pluck('id')->toArray();
        $form = Form::findOrFail($id);
        if(in_array($id, $forms) && $form->publish == true) return view('form', compact('form'));
        abort(404);
    }

    public function submit($subdomain, $id, Request $request)
    {
        $data = $request->all();

        foreach($request->files as $field => $file) {
            if(is_array($file)) {
               $uploadedData = [];
               foreach ($request->file($field) as $singleFile) $uploadedData[] = $this->upload($singleFile);
               $data[$field] = $uploadedData;
            } else {
                $data[$field] = $this->upload($request->file($field));
            }
        }

        if(isset($data['_token'])) unset($data['_token']);

        Data::create([
            'form_id' => $id,
            'user_id' => auth()->id(),
            'data' => json_encode($data),
        ]);

        return redirect()->back()->with('success', 'Form successfully submited.');
    }

    private function upload($file)
    {
        $media = $file->store(auth()->id(), 'local');
        return basename($media);
    }
}
