@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit language</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Language info</h3>
                        </div>
                        <form action="{{ route('languages.update', $lang->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="English" name="name" value="{{ old('name') ?? $lang->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Code</label>
                                                <input type="text" class="form-control" placeholder="en" name="code" value="{{ old('code') ?? $lang->code }}">
                                            </div>
                                            <div class="form-group">
                                                <input id="default" {{($lang->default) ? 'checked' : ''}} type="checkbox" name="default">
                                                <label for="default" class="pl-2">Make Default</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
