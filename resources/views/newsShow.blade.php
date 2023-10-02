@extends('layout')

@section('title')
    {{ $news->title }} | WE Management
@endsection

@section('content')
    <section id="newsSection">
        <div class="news_header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <h1>{{ $news->title }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <article>{!! $news->content !!}</article>
        </div>
    </section>
@endsection
