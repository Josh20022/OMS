@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add new Translation for <span class="text-muted">{{$code}}</span></h1>
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
                            <h3 class="card-title">Translation info</h3>
                        </div>
                        <form action="{{ route('translations.store', $code) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Key</label>
                                                <input type="text" class="form-control" placeholder="first_name" name="key" value="{{ old('key') }}">
                                            </div>
                                            <input type="hidden" name="code" value="{{$code}}">
                                            <div class="form-group">
                                                <label>Text</label>
                                                <input type="text" class="form-control" placeholder="First Name" name="text" value="{{ old('text') }}">
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
