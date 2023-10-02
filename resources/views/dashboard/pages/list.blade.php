@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pages</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($pages) > 0)
                        @php $num = ($pages->currentpage() - 1) * $pages->perpage() + 1 @endphp
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Created</th>
                                        <th>Category</th>
                                        @if(auth()->user()->type == 'admin')
                                            <th>Assigned to</th>
                                        @endif
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $page->title }}</td>
                                            <td>{{ date_format($page->created_at, 'd M Y') }}</td>
                                            <td>{{ $page->category ?? 'none' }}</td>
                                            @if(auth()->user()->type == 'admin')
                                                <td>{{ count($page->users) > 0 ? implode(', ', $page->users->pluck('name')->toArray()) : 'Unassigned' }}</td>
                                            @endif
                                            <td>
                                                <a href="{{ route('pages.show', $page) }}" class="btn btn-info btn-flat">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                <a href="{{ route('pages.edit', $page) }}" class="btn btn-primary btn-flat">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('page.duplicate', $page->id) }}" class="d-inline" method="post">
                                                    @csrf
                                                    <button class="btn btn-warning btn-flat">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-flat page_delete" data-id="{{ $page->id }}" data-name="{{ $page->title }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                {{ $pages->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No existing pages.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
