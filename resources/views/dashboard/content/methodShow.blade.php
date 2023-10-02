@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Method</h1>
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
                            <h3 class="card-title">
                                <span class="btn btn-default mr-2">{{ $method->number }}</span>
                                {{ $method->title }}
                            </h3>
                        </div>
                        <div class="card-body">
                            {{ $method->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

