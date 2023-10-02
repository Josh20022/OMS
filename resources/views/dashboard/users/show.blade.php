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
                            User
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>{{ $user->name }}</b></h2>
                                    <hr>
                                    <p class="text-muted text-sm"><b>Email: </b>{{ $user->email }}</p>
                                    <p class="text-muted text-sm"><b>Company: </b>{{ $user->getCompany() }}</p>
                                    <p class="text-muted text-sm"><b>Registered: </b>{{ date_format($user->created_at, 'd M Y') }}</p>
                                    <p class="text-muted text-sm"><b>Subdomain: </b>{{ $user->subdomain }}</p>
                                    <p class="text-muted text-sm"><b>Color scheme: </b>
                                        <span class="color_scheme" style="background-color: {{ $user->bg_color }}; color: {{ $user->text_color }}">Text</span>
                                    </p>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="{{ $user->getAvatar() }}" alt="user-avatar" class="img-circle" width="128" height="128">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="pb-2">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-flat">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-flat client_delete user_delete" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        @if(count($user->forms) > 0)
                            @if($user->formOrder)
                                <x-forms-order :forms="$user->formOrder->ids" :user="$user->id"/>
                            @else
                                <x-forms-order :forms="$user->forms->pluck('title', 'id')" :user="$user->id"/>
                            @endif
                        @endif
                        @if(count($user->documentationPages) > 0)
                            @php $category = "documentation" @endphp
                            @if($user->documentationOrder)
                                <x-pages-order :pages="$user->documentationOrder->ids" :user="$user->id" :category="$category"/>
                            @else
                                <x-default-pages-order :pages="$user->documentationPages" :user="$user->id" :category="$category"/>
                            @endif
                        @endif
                        @if(count($user->registrationPages) > 0)
                            @php $category = "registration" @endphp
                            @if($user->registrationOrder)
                                <x-pages-order :pages="$user->registrationOrder->ids" :user="$user->id" :category="$category"/>
                            @else
                                <x-default-pages-order :pages="$user->registrationPages" :user="$user->id" :category="$category"/>
                            @endif
                        @endif
                        @if(count($user->reportPages) > 0)
                            @php $category = "report" @endphp
                            @if($user->reportOrder)
                                <x-pages-order :pages="$user->reportOrder->ids" :user="$user->id" :category="$category"/>
                            @else
                                <x-default-pages-order :pages="$user->reportPages" :user="$user->id" :category="$category"/>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    @if(count($user->forms) > 0)
                        <x-forms :forms="$user->forms"/>
                    @else
                        <div class="callout callout-info">
                            <p>No assigned forms to current user.</p>
                        </div>
                    @endif
                    @if(count($user->pages) > 0)
                        <x-assigned-pages :pages="$user->pages"/>
                    @else
                        <div class="callout callout-info">
                            <p>No assigned pages to current user.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
