@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($users) > 0)
                        @php $num = ($users->currentpage() - 1) * $users->perpage() + 1 @endphp
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subdomain</th>
                                        <th>Company</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->subdomain }}</td>
                                            <td>{{ $user->getCompany() }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-flat">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-flat">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-flat client_delete user_delete" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $users->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No registered users.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
