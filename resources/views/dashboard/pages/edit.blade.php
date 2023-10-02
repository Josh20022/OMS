@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit page</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form id="form-create-page" class="row" action="{{ route('pages.update', $page) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="col-12 pb-2">
                    <small>* By editing parent page - assigned users and category will be automatically changed also to children pages.</small>
                    <br>
                    <small>* By editing child page - assigned users and category will be automatically taken form parent's one.</small>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Assigned users</label>
                        <select class="custom-select rounded-0" name="users[]" id="pageUser" multiple>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" @if(in_array($id, $assignedUsers)) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="custom-select rounded-0" name="category">
                            <option value="">None</option>
                            <option value="documentation" @if($page->category == 'documentation') selected @endif>Documentation</option>
                            <option value="registration" @if($page->category == 'registration') selected @endif>Registration</option>
                            <option value="report" @if($page->category == 'report') selected @endif>Report</option>
                            @if(auth()->user()->isAdmin())
                                <option value="news" @if($page->category == 'news') selected @endif>News</option>
                            @endif
                        </select>
                    </div>
                </div>
                @if(count($pages) > 0)
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Parent page</label>
                            <select class="custom-select rounded-0" name="parent">
                                <option value="">None</option>
                                @foreach($pages as $id => $title)
                                    <option value="{{ $id }}" @if($page->parent == $id) selected @endif>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif



                @foreach(\App\Models\Lang::all() as $key => $lang)

                    <div class="col-sm-12">
                    <h3 class="mt-2">{{$lang->name}}</h3>
                    <hr>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title[{{$lang->code}}]" value="{{ $page->getTranslation('title', $lang->code) ?? "" }}">
                    </div>
                    </div>
                    <div class="col-12">
                    <div class="form-group">
                        <label>Description</label>

                        <textarea class="form-control" name="description[{{$lang->code}}]">{{ $page->getTranslation('description', $lang->code) ?? "" }}</textarea>

                    </div>
                    </div>


                    <div class="col-12">
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control pageContent" name="content[{{$lang->code}}]">{{ $page->getTranslation('content', $lang->code) ?? "" }}</textarea>

                        </div>
                    </div>
                @endforeach


                <div class="form-group ml-2">
                    <button type="submit" class="btn btn-primary" id="btn-create-page">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection
