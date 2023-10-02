@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Forms</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($forms) > 0)
                        @php $num = ($forms->currentpage() - 1) * $forms->perpage() + 1 @endphp
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Created</th>
                                        <th>Publish</th>
                                        @if(auth()->user()->type == 'admin')
                                            <th>Assigned to</th>
                                        @endif
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($forms as $form)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $form->title }}</td>
                                            <td>{{ date_format($form->created_at, 'd M Y') }}</td>
                                            <td>{!! $form->getPublishIcon() !!}</td>
                                            @if(auth()->user()->type == 'admin')
                                                <td>{{ count($form->users) > 0 ? implode(', ', $form->users->pluck('name')->toArray()) : 'Unassigned' }}</td>
                                            @endif
                                            <td>
                                                <a href="{{ route('forms.show', $form) }}" class="btn btn-info btn-flat">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                <a href="{{ route('forms.edit', $form) }}" class="btn btn-primary btn-flat">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('form.duplicate', $form->id) }}" class="d-inline" method="post">
                                                    @csrf
                                                    <button class="btn btn-warning btn-flat">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-flat form_delete" data-id="{{ $form->id }}" data-name="{{ $form->title }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $forms->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No created forms.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
