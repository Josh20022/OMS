@extends('layout')

@section('title')
    {{trans('.NEWS')}} | WE Management
@endsection

@section('content')
    <section id="newsSection" class="bg-dark-blue">
        <div class="news_header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <h1>{{trans('.NEWS')}}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            @if(count($news) > 0)
                <div class="row">
                    @foreach($news as $singleNews)
                        <div class="col-12">
                            <div class="single_news">
                                <span>{{ date_format($singleNews->created_at, 'd M Y') }}</span>
                                <a href="{{ route('news.show', $singleNews->id) }}">{{ $singleNews->title }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h2 class="h2-heading mt-5">Sorry, no news at the moment.</h2>
            @endif
        </div>
    </section>
@endsection
