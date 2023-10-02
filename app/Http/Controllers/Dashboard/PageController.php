<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Lang;
use App\Models\Order;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(auth()->user()->isAdmin()) {
            $pages = Page::orderBy('title')->paginate(10);
        } else {
            $ids = $this->getClientPages();
            $pages = Page::whereIn('id', $ids)->orderBy('title')->paginate(10);
        }

        return view('dashboard.pages.list', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->isAdmin()) {
            $users = User::where('type', '!=', 'admin')->orderBy('name')->pluck('name', 'id');
            $pages = Page::where('parent', null)
                ->whereIn('category', ['documentation', 'registration', 'report'])
                ->pluck('title', 'id')
                ->toArray();
        } else {
            $users = auth()->user()->children->pluck('name', 'id');
            $pages = Page::where('parent', null)
                ->whereIn('category', ['documentation', 'registration', 'report'])
                ->whereIn('id', $this->getClientPages())
                ->pluck('title', 'id')
                ->toArray();
        }

        return view('dashboard.pages.create', compact('users', 'pages'));
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

        $category = $request->parent ? Page::find($request->parent)->category : $request->category;

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $category,
            'parent' => $request->parent,
            'description' => $request->description,
            'author' => auth()->id(),
        ];

        $page = Page::create($data);

        if($request->parent) {
            $parentPageUsers = Page::find($request->parent)->users->pluck('id')->toArray();
            $page->users()->sync($parentPageUsers);
            $users = $parentPageUsers;
        } else {
            if(auth()->user()->isAdmin()) {
                $sync = $request->users;
            } else {
                $sync = array_merge($request->users, [auth()->id()]);
            }

            $page->users()->sync($sync);
            $users = $sync;
        }

        if($category && $users && in_array($category, ['documentation', 'registration', 'report'])) {
            foreach($users as $user) {
                $pageOrder = Order::where([
                    ['user_id', $user],
                    ['category', $category]
                ])->first();

                if($pageOrder) {
                    $ids = $pageOrder->ids;
                    $ids[' ' . $page->id] = $request->title;
                    $pageOrder->ids = $ids;
                    $pageOrder->save();
                }
            }
        }


        foreach (Lang::all() as $key => $lang){
            $page->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $page->setTranslation('description', $lang->code, $request->description[$lang->code]);
            $page->setTranslation('content', $lang->code, $request->content[$lang->code]);
        }
        $page->save();

        return redirect()->back()->with('success', 'Page created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        if(!auth()->user()->isAdmin() && !in_array($page->id, $this->getClientPages())) abort('404');
        return view('dashboard.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        if(!auth()->user()->isAdmin() && !in_array($page->id, $this->getClientPages())) abort('404');
        $assignedUsers = $page->users->pluck('id')->toArray();

        if(auth()->user()->isAdmin()) {
            $users = User::where('type', '!=', 'admin')->orderBy('name')->pluck('name', 'id');
            $pages = Page::where([
                ['parent', null],
                ['id', '!=', $page->id]
            ])->whereIn('category', ['documentation', 'registration', 'report'])
                ->pluck('title', 'id')
                ->toArray();
        } else {
            $users = auth()->user()->children->pluck('name', 'id');
            $users[auth()->id()] = auth()->user()->name;
            $pages = Page::where([
                ['parent', null],
                ['id', '!=', $page->id]
            ])->whereIn('category', ['documentation', 'registration', 'report'])
                ->whereIn('id', $this->getClientPages())
                ->pluck('title', 'id')
                ->toArray();
        }

        return view('dashboard.pages.edit', compact('page', 'users', 'pages', 'assignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $this->archive($page);

        if($request->parent) {
            $parentPage = Page::find($request->parent);
            $category = $parentPage->category;
            $parentPageUsers = $parentPage->users->pluck('id')->toArray();
            $page->users()->sync($parentPageUsers);
            $users = $parentPageUsers;
            if(!$page->parent) Page::where('parent', $page->id)->update(['parent' => null]);
        } else {
            $category = $request->category;
            $page->users()->sync($request->users);
            $users = $request->users;
            foreach($page->children as $child) $child->users()->sync($users);
            if(!$page->parent) Page::where('parent', $page->id)->update(['category' => $category]);
        }

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $category,
            'parent' => $request->parent,
            'description' => $request->description,
            'version' => ++$page->version,
        ];

        if($category && $page->category == $category) {
            $orders = Order::where('category', $category)->get();

            foreach($orders as $order) {
                if($users && in_array($order->user_id, $users)) {
                    $ids = $order->ids;
                    $ids[' ' . $page->id] = $request->title;
                    $order->ids = $ids;
                    $order->save();
                } elseif(($users && !in_array($order->user_id, $users)) || !$users) {
                    $ids = $order->ids;
                    unset($ids[' ' . $page->id]);
                    $order->ids = $ids;
                    $order->save();
                }
            }
        } elseif($category && $page->category !== $category) {
            $orders = Order::where('category', $page->category)->get();

            foreach($orders as $order) {
                $ids = $order->ids;
                unset($ids[' ' . $page->id]);
                $order->ids = $ids;
                $order->save();
            }

            if(in_array($category, ['documentation', 'registration', 'report'])) {
                foreach($users as $user) {
                    $order = Order::where([
                        ['user_id', $user],
                        ['category', $category]
                    ])->first();

                    if($order) {
                        $ids = $order->ids;
                        $ids[' ' . $page->id] = $request->title;
                        $order->ids = $ids;
                        $order->save();
                    }
                }
            }
        }

        $page->update($data);

        foreach (Lang::all() as $key => $lang){
            $page->setTranslation('title', $lang->code, $request->title[$lang->code]);
            $page->setTranslation('description', $lang->code, $request->description[$lang->code]);
            $page->setTranslation('content', $lang->code, $request->content[$lang->code]);
        }
        $page->save();
        return redirect()->route('pages.index')->with('success', 'Page updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $users = $page->users->pluck('id')->toArray();

        if($users && $page->category && in_array($page->category, ['documentation', 'registration', 'report'])) {
            foreach($users as $user) {
                $order = Order::where([
                    ['user_id', $user],
                    ['category', $page->category]
                ])->first();

                if($order) {
                    $ids = $order->ids;
                    unset($ids[' ' . $page->id]);
                    $order->ids = $ids;
                    $order->save();
                }
            }
        }

        Page::where('parent', $page->id)->update(['parent' => null]);
        Archive::where('page_id', $page->id)->delete();
        $page->delete();
        $url =  url('') . '/dashboard/pages';
        return response()->json(['status' => 'deleted', 'url' => $url]);
    }

    public function fileUpload(Request $request)
    {
        if($request->hasFile('file')) {
            $folder = date('Y-m');
            $location = $request->file('file')->store("{$folder}");
            return response()->json(['location' => asset("uploads/{$location}")]);
        }
    }

    public function duplicate($id)
    {
        $page = Page::find($id);

        $data = [
            'title' => $page->title . ' - copy',
            'content' => $page->content,
            'author' => auth()->id(),
        ];

        Page::create($data);
        return redirect()->back()->with('success', 'Page duplicated.');
    }

    private function archive($page)
    {
        Archive::create([
            'page_id' => $page->id,
            'description' => $page->description,
            'version' => $page->version,
        ]);
    }

    private function getClientPages()
    {
        $users = auth()->user()->children->pluck('id')->toArray();
        $users[] = auth()->id();
        $createdPages = Page::where('author', auth()->id())->pluck('id')->toArray();
        $ids = DB::table('page_user')->whereIn('user_id', $users)->pluck('page_id')->toArray();
        foreach($createdPages as $key => $id) if(DB::table('page_user')->where('page_id', $id)->exists()) unset($createdPages[$key]);
        $pages = array_unique(array_merge($ids, $createdPages));
        return $pages;
    }
}
