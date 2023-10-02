@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Languages</h1>

                    @include('dashboard.notifications')
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{route('languages.create')}}" class="btn btn-primary">Add New</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($langs) > 0)
                        @php $num = ($langs->currentpage() - 1) * $langs->perpage() + 1 @endphp
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Default</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($langs as $client)
                                            <tr>
                                                <td>{{ $num++ }}</td>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->code }}</td>
                                                <td>

                                                    @if($client->default )
                                                        <span class="badge badge-success">default</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="{{ route('translations.index', $client->code) }}" class="btn btn-warning btn-flat">
                                                        <i class="fa fa-solid fa-language"></i>
                                                    </a>
                                                    <a href="{{ route('languages.edit', $client) }}" class="btn btn-primary btn-flat">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-flat lang_delete" data-id="{{ $client->id }}" data-name="{{ $client->name }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $langs->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No registered Language.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
