@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ISO standard</h1>
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
                            <h3 class="card-title">{{ $iso->title }}</h3>
                        </div>
                        <div class="card-body">
                            {{ $iso->content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

