@extends('layout')

@section('title')
    Reset password | WE Management
@endsection

@section('content')
    <section id="loginSection">
        <div class="login_inner short">
            <div class="row">
                <div class="col">
                    <form action="{{ route('reset') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h3 class="text-center">Reset password</h3>
                        <hr>
                        @if(session('error'))
                            <div class="form-group checkbox text-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="form-group checkbox text-danger">
                                @foreach ($errors->all() as $error)
                                    <span class="d-block">{{ $error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="email" class="form-control-input" name="email">
                            <label class="label-control">E-mailadres</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control-input" name="password">
                            <label class="label-control">Password</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control-input" name="password_confirmation">
                            <label class="label-control">Confirm password</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">RESET</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
