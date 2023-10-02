@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add new client</h1>
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
                            <h3 class="card-title">Client info</h3>
                        </div>
                        <form action="{{ route('clients.store') }}" method="post" enctype="multipart/form-data">
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
                                            <div class="form-group">
                                                <label>Subdomain</label>
                                                <input type="text" class="form-control" placeholder="Subdomain" name="subdomain" value="{{ old('subdomain') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Avatar</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="avatar">
                                                        <label class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>
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
        </div>
    </section>
@endsection
