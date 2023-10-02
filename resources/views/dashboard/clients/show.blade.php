@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light card-primary card-outline">
                        <div class="card-header text-muted border-bottom-0">
                            Client
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>{{ $client->name }}</b></h2>
                                    <hr>
                                    <p class="text-muted text-sm"><b>Email: </b>{{ $client->email }}</p>
                                    <p class="text-muted text-sm"><b>Registered: </b>{{ date_format($client->created_at, 'd M Y') }}</p>
                                    @if(auth()->user()->isAdmin())
                                        <p class="text-muted text-sm"><b>Subdomain: </b>{{ $client->subdomain }}</p>
                                        <p class="text-muted text-sm"><b>Color scheme: </b>
                                            <span class="color_scheme" style="background-color: {{ $client->bg_color }}; color: {{ $client->text_color }}">Text</span>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-5 text-center">
                                    <img src="{{ $client->getAvatar() }}" alt="user-avatar" class="img-circle" width="128" height="128">
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->isAdmin())
                            <div class="card-footer">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pb-2">
                                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary btn-flat">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-flat client_delete" data-id="{{ $client->id }}" data-name="{{ $client->name }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        @if(count($client->forms) > 0)
                            @if($client->formOrder)
                                <x-forms-order :forms="$client->formOrder->ids" :user="$client->id"/>
                            @else
                                <x-forms-order :forms="$client->forms->pluck('title', 'id')" :user="$client->id"/>
                            @endif
                        @endif
                        @if(count($client->documentationPages) > 0)
                            @php $category = "documentation" @endphp
                            @if($client->documentationOrder)
                                <x-pages-order :pages="$client->documentationOrder->ids" :user="$client->id" :category="$category"/>
                            @else
                                <x-default-pages-order :pages="$client->documentationPages" :user="$client->id" :category="$category"/>
                            @endif
                        @endif
                        @if(count($client->registrationPages) > 0)
                            @php $category = "registration" @endphp
                            @if($client->registrationOrder)
                                <x-pages-order :pages="$client->registrationOrder->ids" :user="$client->id" :category="$category"/>
                            @else
                                <x-default-pages-order :pages="$client->registrationPages" :user="$client->id" :category="$category"/>
                            @endif
                        @endif
                        @if(count($client->reportPages) > 0)
                            @php $category = "report" @endphp
                            @if($client->reportOrder)
                                <x-pages-order :pages="$client->reportOrder->ids" :user="$client->id" :category="$category"/>
                            @else
                                <x-default-pages-order :pages="$client->reportPages" :user="$client->id" :category="$category"/>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    @if(count($client->children) > 0)
                        <div class="card card-primary collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Linked users</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subdomain</th>
                                        <th>Profile</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($client->children as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->subdomain }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-flat">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No linked users to current client.</p>
                        </div>
                    @endif
                    @if(count($client->forms) > 0)
                        <x-forms :forms="$client->forms"/>
                    @else
                        <div class="callout callout-info">
                            <p>No assigned forms to current client.</p>
                        </div>
                    @endif
                    @if(count($client->pages) > 0)
                        <x-assigned-pages :pages="$client->pages"/>
                    @else
                        <div class="callout callout-info">
                            <p>No assigned pages to current client.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
