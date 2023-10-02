@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit ISO standard</h1>
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
                            <h3 class="card-title">ISO standard info</h3>
                        </div>
                        <form action="{{ route('isos.update', $iso) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                @foreach(\App\Models\Lang::all() as $key => $lang)

                                    <h3 class="mt-2">{{$lang->name}}</h3>
                                    <hr>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title[{{$lang->code}}]" value="{{ $iso->getTranslation('title', $lang->code) ?? "" }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control" name="content[{{$lang->code}}]">{{ $iso->getTranslation('content', $lang->code) ?? "" }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

