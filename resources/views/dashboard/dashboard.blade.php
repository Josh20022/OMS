@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if($clients > 0)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $clients }}</h3>
                                <p>CLIENTS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <a href="{{ route('clients.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
                @if($users > 0)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $users }}</h3>
                                <p>USERS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <a href="{{ route('users.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
                @if($forms > 0)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $forms }}</h3>
                                <p>FORMS</p>
                            </div>
                            <div class="icon">
                                <i class="fab fa-wpforms"></i>
                            </div>
                            <a href="{{ route('forms.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
                @if($pages > 0)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $pages }}</h3>
                                <p>PAGES</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <a href="{{ route('pages.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
