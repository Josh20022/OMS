@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Clients</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($clients) > 0)
                        @php $num = ($clients->currentpage() - 1) * $clients->perpage() + 1 @endphp
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subdomain</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <td>{{ $num++ }}</td>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->subdomain }}</td>
                                                <td>
                                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-flat">
                                                        <i class="fas fa-link"></i>
                                                    </a>
                                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary btn-flat">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('client.duplicate', $client->id) }}" class="d-inline" method="post">
                                                        @csrf
                                                        <button class="btn btn-warning btn-flat">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger btn-flat client_delete" data-id="{{ $client->id }}" data-name="{{ $client->name }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $clients->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No registered clients.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
