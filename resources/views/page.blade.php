@extends('layout')

@section('title')
    {{ $page->title }} | WE Management
@endsection

@php
    $bg = 'style=background-color:' . auth()->user()->bg_color;
    $text = 'style=color:' . auth()->user()->text_color;
    $bgColor = auth()->user()->bg_color;
    $textColor = auth()->user()->text_color;
@endphp
@section('content')
    <section id="pageSection">
        <div class="container">
            <div class="tab_header" style="background-color: {{ auth()->user()->bg_color }}">
                <h5 class="card-title m-0" style="color: {{ auth()->user()->text_color }}">
                    @if($page->parents)
                        <a class="page_link" href="{{ url(getProtocol() . auth()->user()->subdomain . '.' . getDomain() . '/page/' . $page->parents->id) }}">
                            {{ $page->parents->title }}
                        </a>
                        <i class="fas fa-long-arrow-alt-right"></i>
                    @endif
                    {{ $page->title }}
                </h5>
            </div>
            <article>{!! $page->content !!}</article>
        </div>
    </section>
</div>
@endsection
