@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#info" role="tab" aria-selected="true">Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#description" role="tab" aria-selected="false">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#template" role="tab" aria-selected="false">Template</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#history" role="tab" aria-selected="false">History</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="info" role="tabpanel">
                                    <div class="col-3">
                                        <h2 class="lead">{{ $page->title }}</h2>
                                        <hr>
                                        <p class="text-muted text-sm">
                                            <b>Assigned to: </b>
                                            {{ count($page->users) > 0 ? implode(', ', $page->users->pluck('name')->toArray()) : 'Unassigned' }}
                                        </p>
                                        <p class="text-muted text-sm"><b>Category: </b>{{ $page->category ?? 'none' }}</p>
                                        <p class="text-muted text-sm"><b>Version: </b>{{ $page->version }}.0</p>
                                        <p class="text-muted text-sm"><b>Created: </b>{{ date_format($page->created_at, 'd M Y') }}</p>
                                        <p class="text-muted text-sm"><b>Last update: </b>{{ date_format($page->updated_at, 'd M Y') }}</p>
                                        @if($page->parent)
                                            <p class="text-muted text-sm"><b>Parent page: </b>{{ $page->parentPage() }}</p>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="col-12">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="pb-2">
                                                        <a href="{{ route('pages.edit', $page) }}" class="btn btn-primary btn-flat">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-flat page_delete" data-id="{{ $page->id }}" data-name="{{ $page->title }}">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="description" role="tabpanel">
                                    @if($page->description)
                                        {{ $page->description }}
                                    @else
                                        <p>
                                            <i class="fas fa-exclamation text-danger text-lg pr-2"></i>
                                            Page doesn't have description.
                                        </p>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="template" role="tabpanel">
                                    <div id="template-wrap">{!! $page->content !!}</div>
                                </div>
                                <div class="tab-pane fade" id="history" role="tabpanel">
                                    @if(count($page->archives) > 0)
                                        @foreach($page->archives as $archive)
                                            <p class="text-muted text-sm">
                                                <b>Version {{ $archive->version }}.0 | <span class="text-xs">{{ date_format($page->created_at, 'd M Y') }}</span></b>
                                                <br>
                                                {{ $archive->description }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p>
                                            <i class="fas fa-exclamation text-danger text-lg pr-2"></i>
                                            Page doesn't have history.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

