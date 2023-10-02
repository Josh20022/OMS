<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->isAdmin()) {
            $forms = Form::orderBy('title')->paginate(10);
        } else {
            $ids = $this->getClientForms();
            $forms = Form::whereIn('id', $ids)->orderBy('title')->paginate(10);
        }

        return view('dashboard.forms.list', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = auth()->user()->isAdmin() ? User::where('type', '!=', 'admin')->orderBy('name')->pluck('name', 'id') : auth()->user()->children->pluck('name', 'id');
        return view('dashboard.forms.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'title' => $request->title,
            'template' => $request->input('template'),
            'publish' => $request->publish,
            'author' => auth()->id(),
        ];

        $form = Form::create($data);

        if(auth()->user()->isAdmin()) {
            $sync = $request->users;
        } else {
            $sync = array_merge($request->users, [auth()->id()]);
        }

        $form->users()->sync($sync);

        foreach($request->users as $user) {
            $formOrder = Order::where([
                ['user_id', $user],
                ['type', 'form']
            ])->first();

            if($formOrder) {
                $ids = $formOrder->ids;
                $ids[' ' . $form->id] = $request->title;
                $formOrder->ids = $ids;
                $formOrder->save();
            }
        }

        $url = url('') . '/dashboard/forms';
        return response()->json(['status' => true, 'url' => $url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        if(!auth()->user()->isAdmin() && !in_array($form->id, $this->getClientForms())) abort('404');
        $users = User::pluck('name', 'id')->toArray();
        return view('dashboard.forms.show', compact('form', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        if(!auth()->user()->isAdmin() && !in_array($form->id, $this->getClientForms())) abort('404');
        $users = auth()->user()->isAdmin() ? User::where('type', '!=', 'admin')->orderBy('name')->pluck('name', 'id') : auth()->user()->children->pluck('name', 'id');
        if(!auth()->user()->isAdmin()) $users[auth()->id()] = auth()->user()->name;
        $assignedUsers = $form->users->pluck('id')->toArray();
        return view('dashboard.forms.edit', compact('form', 'users', 'assignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $data = [
            'title' => $request->title,
            'publish' => $request->publish,
            'template' => $request->input('template'),
        ];

        $formUsers = $form->users->pluck('id')->toArray();

        foreach($request->users as $user) {
            $formOrder = Order::where([
                ['user_id', $user],
                ['type', 'form']
            ])->first();

            if($formOrder) {
                $ids = $formOrder->ids;
                $ids[' ' . $form->id] = $request->title;
                $formOrder->ids = $ids;
                $formOrder->save();
            }
        }

        foreach($formUsers as $user) {
            if(!in_array($user, $request->users)) {
                $formOrder = Order::where([
                    ['user_id', $user],
                    ['type', 'form']
                ])->first();

                if($formOrder) {
                    $ids = $formOrder->ids;
                    unset($ids[' ' . $form->id]);
                    $formOrder->ids = $ids;
                    $formOrder->save();
                }
            }
        }

        $form->update($data);
        $form->users()->sync($request->users);
        $url = url('') . '/dashboard/forms';
        return response()->json(['status' => true, 'url' => $url]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $formUsers = $form->users->pluck('id')->toArray();

        foreach($formUsers as $user) {
            $formOrder = Order::where([
                ['user_id', $user],
                ['type', 'form']
            ])->first();

            if($formOrder) {
                $ids = $formOrder->ids;
                unset($ids[' ' . $form->id]);
                $formOrder->ids = $ids;
                $formOrder->save();
            }
        }

        $form->delete();
        $form->data()->delete();
        $form->users()->detach();
        $url =  url('') . '/dashboard/forms';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }

    public function duplicate($id)
    {
        $form = Form::find($id);

        $data = [
            'title' => $form->title . ' - copy',
            'template' => $form->template,
            'author' => auth()->id(),
        ];

        Form::create($data);
        return redirect()->back()->with('success', 'Form duplicated.');
    }

    public function data(Request $request, $id)
    {
        if(!auth()->user()->isAdmin() && !in_array($id, $this->getClientForms())) abort('404');

        $request->validate(['field' => 'required']);
        $form = Form::find($id);
        $fields = $form->data;
        $expandField = $request->field;
        $users = User::pluck('name', 'id')->toArray();

        $firstKey = array_key_first($fields->toArray());
        $key = array_search($expandField, array_column($fields[$firstKey]->data, 'name'));
        $excludedArray = $fields[$firstKey]->data;
        unset($excludedArray[$key]);

        return view('dashboard.forms.data', compact('id', 'fields', 'expandField', 'users', 'excludedArray', 'key', 'firstKey'));
    }

    private function getClientForms()
    {
        $users = auth()->user()->children->pluck('id')->toArray();
        $users[] = auth()->id();
        $createdForms = Form::where('author', auth()->id())->pluck('id')->toArray();
        $ids = DB::table('form_user')->whereIn('user_id', $users)->pluck('form_id')->toArray();
        foreach($createdForms as $key => $id) if(DB::table('form_user')->where('form_id', $id)->exists()) unset($createdForms[$key]);
        $forms = array_unique(array_merge($ids, $createdForms));
        return $forms;
    }
}
