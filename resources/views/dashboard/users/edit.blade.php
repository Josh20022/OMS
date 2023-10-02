@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit profile</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User info</h3>
                        </div>
                        <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="removeAvatar" name="_remove_avatar" value="keep_avatar">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}">
                                            </div>
                                            @if(auth()->user()->isAdmin())
                                                <div class="form-group">
                                                    <label>Client</label>
                                                    <select class="custom-select rounded-0" name="company">
                                                        @foreach($clients as $client)
                                                            <option value="{{ $client->id }}" @if($client->id == $user->company) selected @endif>{{ $client->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="company" value="{{ auth()->id() }}">
                                            @endif
                                            <div class="form-group">
                                                <label>Subdomain</label>
                                                <input type="text" class="form-control" placeholder="Subdomain" name="subdomain" value="{{ $user->subdomain }}">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Background color</label>
                                                        <input type="color" class="d-block form-control" name="bg_color" value="{{ $user->bg_color }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Text color</label>
                                                        <input type="color" class="d-block form-control" name="text_color" value="{{ $user->text_color }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Welcome text</label>
                                                <textarea id="welcomeText" name="welcome_text">{{ $user->welcome_text }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update and send credentials</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
