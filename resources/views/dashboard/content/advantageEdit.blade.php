@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit advantage</h1>
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
                            <h3 class="card-title">Advantage info</h3>
                        </div>
                        <form action="{{ route('advantages.update', $advantage) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label>"Fontawesome" icon</label>
                                    <input type="text" class="form-control" placeholder="Icon" name="icon" value="{{ old('icon') ?? $advantage->icon }}">
                                </div>

                                @foreach(\App\Models\Lang::all() as $key => $lang)

                                    <h3 class="mt-2">{{$lang->name}}</h3>
                                    <hr>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title[{{$lang->code}}]" value="{{ $advantage->getTranslation('title', $lang->code) ?? "" }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>

                                        <textarea class="form-control" name="description[{{$lang->code}}]">{{ $advantage->getTranslation('description', $lang->code) ?? "" }}</textarea>

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

