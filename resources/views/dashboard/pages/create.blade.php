@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create page</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form id="form-create-page" class="row" action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-12 pb-2">
                    <small>* By selecting parent page - assigned users and category will be automatically set to parent's ones.</small>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Assigned users</label>
                        <select class="custom-select rounded-0" name="users[]" id="pageUser" multiple>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="custom-select rounded-0" name="category">
                            <option value="">None</option>
                            <option value="documentation">Documentation</option>
                            <option value="registration">Registration</option>
                            <option value="report">Report</option>
                            @if(auth()->user()->isAdmin())
                                <option value="news">News</option>
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
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif


                @foreach(\App\Models\Lang::all() as $lang)


                    <div class="col-sm-12">
                        <h3 class="mt-2">{{$lang->name}}</h3>
                        <hr>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" placeholder="Title" name="title[{{$lang->code}}]" value="">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" placeholder="Description" name="description[{{$lang->code}}]"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Content</label>
                            <textarea id="pageContent3" class="form-control pageContent" placeholder="Content" name="content[{{$lang->code}}]"></textarea>


                        </div>
                    </div>
                @endforeach
                <div class="form-group ml-2">
                    <button type="submit" class="btn btn-primary" id="btn-create-page">Create page</button>
                </div>
            </form>
        </div>
    </section>
@endsection
