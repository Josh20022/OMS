@extends('layout')

@section('title')
    Profile | WE Management
@endsection
<!--	get color from company --!>
@php
if(isset($user->parents)){
	$bg = 'style=background-color:' . $user->parents->bg_color;
    	$text = 'style=color:' . $user->parents->text_color;
    	$bgColor = $user->parents->bg_color;
    	$textColor = $user->parents->text_color;
} else {
    $bg = 'style=background-color:' . $user->bg_color;
    $text = 'style=color:' . $user->text_color;
    $bgColor = $user->bg_color;
    $textColor = $user->text_color;
}
@endphp

@section('content')
    <section id="profileSection">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card" {{ $bg }}>
                        <div class="card-image text-center">
                            <div class="profile_img">
                                <img src="{{ $user->getAvatar() }}" alt="profile">
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title" {{ $text }}>{{ $user->name }}</h5>
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" data-toggle="tab" href="#welcome" role="tab" aria-selected="true">
                            <i class="fas fa-home"></i>{{trans('.HOME')}}
                        </a>
                        <a class="nav-link" data-toggle="tab" href="#info" role="tab" aria-selected="false">
                            <i class="fas fa-user"></i> {{trans('.Info')}}
                        </a>
                        <a class="nav-link" data-toggle="tab" href="#documentation" role="tab" aria-selected="false">
                            <i class="fas fa-square"></i>{{trans('.Documentation')}}
                        </a>
                        <a class="nav-link" data-toggle="tab" href="#registration" role="tab" aria-selected="false">
                            <i class="fas fa-square"></i>{{trans('.Registrations')}}
                        </a>
                        <a class="nav-link" data-toggle="tab" href="#report" role="tab" aria-selected="false">
                            <i class="fas fa-square"></i>{{trans('.Reports')}}
                        </a>
                        @if($user->type !== 'user')
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-th"></i>{{trans('.Dashboard')}}
                            </a>
                        @endif
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt"></i>{{trans('.Logout')}}
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content">
                        <div class="tab_header" {{ $bg }}>
                            @if(count($filteredForms) > 0)
                                @foreach($filteredForms as $id => $title)
                                    <a
                                            style="background-color: {{ $textColor }}; color: {{ $bgColor }}"
                                            class="form_link"
                                            href="{{ url(getProtocol() . $user->subdomain . '.' . getDomain() . '/form/' . $id) }}"
                                    >
                                        {{ $title }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                        <div class="tab-pane fade show active" id="welcome" role="tabpanel">
                            @include('notifications')
				<!--	get welcome text from company --!>
                            	<div class="welcome_text">
						@if(isset($user->parents->welcome_text))
						{!! $user->parents->welcome_text !!}
						@else
						{!! $user->welcome_text !!}
						@endif
					</div>
                        </div>
                        <div class="tab-pane fade" id="info" role="tabpanel">
                            <ul class="ul profile_info_list">
                                <li>
                                    <b class="checkbox">{{trans('.Name')}}:</b> {{ $user->name }}
                                </li>
                                <li>
                                    <b class="checkbox">{{trans('.Email')}}:</b> {{ $user->email }}
                                </li>
                                <li>
                                    <b class="checkbox">{{trans('.Registered')}}:</b> {{ date_format($user->created_at, 'd M Y') }}
                                </li>
                            </ul>
                            <hr>
                            <button
                                    style="background-color: {{ $bgColor }}; color: {{ $textColor }}"
                                    class="text-uppercase profile_edit_btn"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#editForm"
                            >
                                {{trans('.Edit')}}
                            </button>
                            <div class="collapse" id="editForm">
                                <div class="card card-body">
                                    <form action="{{ url(getProtocol() . $user->subdomain . '.' . getDomain() . '/profile') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" id="removeAvatar" name="_remove_avatar" value="keep_avatar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="checkbox font-weight-bold"> {{trans('.Name')}}</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="checkbox font-weight-bold">{{trans('.Email')}}</label>
                                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="checkbox font-weight-bold">{{trans('.Change password')}}</label>
                                                    <input type="password" class="form-control mb-4" name="password" placeholder="{{trans('.New password')}}">
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="{{trans('.Confirm password')}}">
                                                </div>
                                            </div>
                                            @if(auth()->user()->type !== 'user')
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label class="checkbox font-weight-bold">{{trans('.Avatar')}}</label>
                                                        @if($user->avatar)
                                                            <div class="pb-2 edit_avatar">
                                                                <img
                                                                        width="60"
                                                                        height="60"
                                                                        class="rounded-circle"
                                                                        src="{{ asset("uploads/{$user->avatar}") }}"
                                                                        alt="{{ $user->name }}"
                                                                >
                                                                <button
                                                                        type="button"
                                                                        class="profile_edit_btn remove_avatar ml-4"
                                                                        style="background-color: {{ $bgColor }}; color: {{ $textColor }}"
                                                                >
                                                                    Remove
                                                                </button>
                                                            </div>
                                                        @endif
                                                        <input type="file" class="form-control file_form_control" name="avatar">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <button
                                                    type="submit"
                                                    class="profile_edit_btn"
                                                    style="background-color: {{ $bgColor }}; color: {{ $textColor }}"
                                            >
                                                {{trans('.UPDATE')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="documentation" role="tabpanel">
                            <x-pages :pages="$documentations" :subdomain="$user->subdomain"/>
                        </div>
                        <div class="tab-pane fade" id="registration" role="tabpanel">
                            <x-pages :pages="$registrations" :subdomain="$user->subdomain"/>
                        </div>
                        <div class="tab-pane fade" id="report" role="tabpanel">
                            <x-pages :pages="$reports" :subdomain="$user->subdomain"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
