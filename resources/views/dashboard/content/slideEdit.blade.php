@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit slide</h1>
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
                            <h3 class="card-title">Slide info</h3>
                        </div>
                        <form action="{{ route('slides.update', $slide) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Current image</label>
                                    <div class="slide_img bg_cover" style="background-image: url({{ asset("uploads/{$slide->image}") }})"></div>
                                </div>
                                <div class="form-group">
                                    <label>New image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                @foreach(\App\Models\Lang::all() as $key => $lang)
                                    <h3 class="mt-2">{{$lang->name}}</h3>
                                    <hr>

                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control" name="description[{{$lang->code}}]">{{ $slide->getTranslation('description', $lang->code) ?? "" }}</textarea>
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

