@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <img style="max-height: 25px" src="https://unpkg.com/language-icons@0.3.0/icons/{{$code}}.svg" alt="">
                        Translations
                        <small>{{$code}}</small>
                    </h1>

                    @include('dashboard.notifications')
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{route('translations.create', $code)}}" class="btn btn-primary">Add New</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($translations) > 0)
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>key</th>
                                            <th>Text</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($translations as $key => $client)
                                            <tr>
                                                <td>{{  $code }}</td>
                                                <td>{{ $client->key }}</td>
                                                <td>{{ $client->text[$code]  ?? ''}}</td>
                                                <td>
                                                    <a href="{{ route('translations.edit', ['code' => $code, $client->id]) }}" class="btn btn-primary btn-flat">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>No registered Translations.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
