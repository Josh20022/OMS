@extends('layout')

@section('title')
    {{trans('.Forgot password')}} | WE Management
@endsection

@section('content')
    <section id="loginSection">
        <div class="login_inner short">
            <div class="row">
                <div class="col">
                    <form action="{{ route('forgot') }}" method="post">
                        @csrf
                        <h3 class="text-center">{{trans('.Forgot password')}}</h3>
                        <hr>
                        @if(session('success'))
                            <div class="form-group checkbox text-success">
                                {{ session('success') }}
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
                            <label class="label-control"> {{trans('.E-mail address')}}</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">{{trans('.SUBMIT')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
