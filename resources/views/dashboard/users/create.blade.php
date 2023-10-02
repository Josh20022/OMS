@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add new user</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @if(count($clients) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User info</h3>
                            </div>
                            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                                                </div>
                                                @if(auth()->user()->isAdmin())
                                                    <div class="form-group">
                                                        <label>Client</label>
                                                        <select class="custom-select rounded-0" name="company">
                                                            <option value="">Select client</option>
                                                            @foreach($clients as $client)
                                                                <option value="{{ $client->id }}" @if(old('company') == $client->id) selected @endif>{{ $client->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="company" value="{{ auth()->id() }}">
                                                @endif
                                                <div class="form-group">
                                                    <label>Subdomain</label>
                                                    <input type="text" class="form-control" placeholder="Subdomain" name="subdomain" value="{{ old('subdomain') }}">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Background color</label>
                                                            <input type="color" class="d-block form-control" name="bg_color" value="{{ old('bg_color') ?? '#3a3458' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Text color</label>
                                                            <input type="color" class="d-block form-control" name="text_color" value="{{ old('text_color') ?? '#ffffff' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" placeholder="Password" name="password" value="{{ generatePassword() }}">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Welcome text</label>
                                                    <textarea id="welcomeText" name="welcome_text">{{ old('welcome_text') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit and send credentials</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="callout callout-info">
                    <p>No registered clients to assign user.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
