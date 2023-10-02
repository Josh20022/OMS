@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form class="row" action="{{ route('settings.store') }}" method="post">
                @csrf
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Contact info</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $settings->email ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{ $settings->phone ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" placeholder="Address" name="address" value="{{ $settings->address ?? "" }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Social</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control" placeholder="Facebook" name="facebook" value="{{ $settings->facebook ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label>Twitter</label>
                                <input type="text" class="form-control" placeholder="Twitter" name="twitter" value="{{ $settings->twitter ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label>Linkedin</label>
                                <input type="text" class="form-control" placeholder="Linkedin" name="linkedin" value="{{ $settings->linkedin ?? "" }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection

