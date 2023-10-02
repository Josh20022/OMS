@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Methods</h1>
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
                            <h3 class="card-title">Add method</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('methods.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Number</label>
                                    <input type="number" class="form-control" min="1" name="number" placeholder="Number" value="{{ old('number') }}">
                                </div>
                                @foreach(\App\Models\Lang::all() as $lang)
                                    <h3 class="mt-2">{{$lang->name}}</h3>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" placeholder="Title" name="title[{{$lang->code}}]" value="">

                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" placeholder="Description" name="description[{{$lang->code}}]"></textarea>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if(count($methods) > 0)
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Methods</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($methods as $method)
                                            <tr>
                                                <td>{{ $method->number }}</td>
                                                <td>{{ $method->title }}</td>
                                                <td class="text-nowrap">
                                                    <a href="{{ route('methods.show', $method) }}" class="btn btn-info btn-flat">
                                                        <i class="fas fa-link"></i>
                                                    </a>
                                                    <a href="{{ route('methods.edit', $method) }}" class="btn btn-primary btn-flat">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-flat method_delete" data-id="{{ $method->id }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No existing methods.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

