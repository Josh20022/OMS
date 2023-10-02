@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ISO standards</h1>
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
                            <h3 class="card-title">Add ISO standard</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('isos.store') }}" method="post">
                                @csrf

                                @foreach(\App\Models\Lang::all() as $lang)
                                    <h3 class="mt-2">{{$lang->name}}</h3>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" placeholder="Title" name="title[{{$lang->code}}]" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control" placeholder="Content" name="content[{{$lang->code}}]"></textarea>
                                    </div>
                                    <hr>
                                @endforeach
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if(count($standards) > 0)
                        @php $num = ($standards->currentpage() - 1) * $standards->perpage() + 1 @endphp
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">ISO standards</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($standards as $standard)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $standard->title }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('isos.show', $standard) }}" class="btn btn-info btn-flat">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                <a href="{{ route('isos.edit', $standard) }}" class="btn btn-primary btn-flat">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-flat iso_delete" data-id="{{ $standard->id }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $standards->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No ISO standards.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

