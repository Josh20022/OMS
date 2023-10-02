@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Slides</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Add slide</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('slides.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Image</label>
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
                                        <label>Description</label>
                                        <textarea class="form-control"  placeholder="Description" name="description[{{$lang->code}}]"></textarea>
                                    </div>

                                @endforeach
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if(count($slides) > 0)
                        @php $num = ($slides->currentpage() - 1) * $slides->perpage() + 1 @endphp
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Slides</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($slides as $slide)
                                            <tr>
                                                <td>{{ $num++ }}</td>
                                                <td>
                                                    <div class="slide_img bg_cover" style="background-image: url({{ asset("uploads/{$slide->image}") }})"></div>
                                                </td>
                                                <td>{!! $slide->description ?? '<i class="text-red">No description</i>' !!}</td>
                                                <td class="text-nowrap">
                                                    <a href="{{ route('slides.edit', $slide) }}" class="btn btn-primary btn-flat">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-flat slide_delete" data-id="{{ $slide->id }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $slides->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No existing slides.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

