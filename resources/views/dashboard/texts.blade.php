@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Content texts</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('texts.store') }}" method="post">
                @csrf


                @foreach(\App\Models\Lang::all() as $key => $lang)

                    <h3 class="mt-2">{{$lang->name}}</h3>
                    <hr>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Main</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Intro</label>
                                        <textarea class="form-control" name="intro[{{$lang->code}}]">{{ $texts->getTranslation('intro', $lang->code) ?? "" }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>About</label>
                                        <textarea class="form-control" name="about[{{$lang->code}}]">{{ $texts->getTranslation('about', $lang->code) ?? "" }}</textarea>

                                    </div>
                                    <div class="form-group">
                                        <label>Details</label>
                                        <textarea class="form-control" name="details[{{$lang->code}}]">{{ $texts->getTranslation('details', $lang->code) ?? "" }}</textarea>

                                    </div>
                                </div>
                            </div>


                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Mission block</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="mission_title[{{$lang->code}}]" value="{{ $texts->getTranslation('mission_title', $lang->code) ?? "" }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Text</label>
                                        <textarea class="form-control" name="mission[{{$lang->code}}]">{{ $texts->getTranslation('mission', $lang->code) ?? "" }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Additional</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Slider block title</label>
                                        <input type="text" class="form-control" name="slider[{{$lang->code}}]" value="{{ $texts->getTranslation('slider', $lang->code) ?? "" }}">

                                    </div>
                                    <div class="form-group">
                                        <label>ISO standards block title</label>
                                        <input type="text" class="form-control" name="iso[{{$lang->code}}]" value="{{ $texts->getTranslation('iso', $lang->code) ?? "" }}">

                                    </div>
                                    <div class="form-group">
                                        <label>Methods block title</label>
                                        <input type="text" class="form-control" name="method_title[{{$lang->code}}]" value="{{ $texts->getTranslation('method_title', $lang->code) ?? "" }}">

                                    </div>
                                    <div class="form-group">
                                        <label>Methods block subtitle</label>
                                        <input type="text" class="form-control" name="method_subtitle[{{$lang->code}}]" value="{{ $texts->getTranslation('method_subtitle', $lang->code) ?? "" }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">OMS block</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Title</label>

                                        <input type="text" class="form-control" name="oms_title[{{$lang->code}}]" value="{{ $texts->getTranslation('oms_title', $lang->code) ?? "" }}">

                                    </div>
                                    <div class="form-group">
                                        <label>Text</label>
                                        <textarea class="form-control" name="oms[{{$lang->code}}]">{{ $texts->getTranslation('oms', $lang->code) ?? "" }}</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection

