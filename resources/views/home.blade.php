@extends('layout')

@section('content')
    <section id="home" class="header" style="background-image: url({{ asset('assets/img/header-background.jpg') }})">
        @if($texts && $texts['intro'])
            <div class="container">
                <div class="header_text">
                    <p class="h3">{{ $texts['intro'] }}</p>
                </div>
            </div>
        @endif
    </section>
    <section class="cards-1 bg-dark-blue">
        <div class="container">
            @if(count($advantages) > 0)
                <div class="row">
                    @foreach($advantages->chunk(2) as $row)
                        <div class="col-lg-12">
                            @foreach($row as $advantage)
                                <div class="card">
                                    <div class="card-image">
                                        {!! $advantage->icon !!}
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $advantage->title }}</h5>
                                        <p class="checkbox">{{ $advantage->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
            @if(count($slides) > 0)
                <div class="row header">
                    <div class="col">
                        @if($texts && $texts['slider'])
                            <p class="mb-3"><i>{{ $texts['slider'] }}</i></p>
                        @endif
                        <div class="slider-container">
                            <div class="swiper-container text-slider">
                                <div class="swiper-wrapper">
                                    @foreach($slides as $slide)
                                        <div class="swiper-slide">
                                            <div class="row">
                                                <div class="col">
                                                    <img src="{{ asset("uploads/{$slide->image}") }}" alt="we-management">
                                                    @if($slide->description)
                                                        <div class="slide_text checkbox">
                                                            {{ $slide->description }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <section class="contrast_section">
        <div class="container">
            @if($texts && $texts['oms_title'])
                <h4>{{ $texts['oms_title'] }}</h4>
            @endif
            @if($texts && $texts['oms'])
                <p class="m-0">{{ $texts['oms'] }}</p>
            @endif
        </div>
    </section>
    @if(count($methods) > 0)
        <section id="werkwijze" class="basic-4 bg-dark-blue">
            <div class="container">
                @if($texts && $texts['method_title'])
                    <h2 class="h2-heading text-center">{{ $texts['method_title'] }}</h2>
                @endif
                @if($texts && $texts['method_subtitle'])
                    <p class="mb-6 text-center"><i>{{ $texts['method_subtitle'] }}</i></p>
                @endif
                <div class="row">
                    @foreach($methods as $method)
                        <div class="col-md-6 d-flex">
                            <div class="card flex-fill">
                                <div class="row">
                                    <div class="col-auto">
                                        <span class="werkwijze_num">{{ $method->number }}</span>
                                    </div>
                                    <div class="col">
                                        <h4>{{ $method->title }}</h4>
                                        <p class="checkbox">{{ $method->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section class="contrast_section">
        <div class="container">
            @if($texts && $texts['mission_title'])
                <h4>{{ $texts['mission_title'] }}</h4>
            @endif
            @if($texts && $texts['mission'])
                <p class="m-0">{{ $texts['mission'] }}</p>
            @endif
        </div>
    </section>
    @if(count($standards) > 0)
        <section class="iso_list bg-dark-blue">
            <div class="container">
                <div class="col">
                    @if($texts && $texts['iso'])
                        <p class="mb-3 text-center"><i>{{ $texts['iso'] }}</i></p>
                    @endif
                    <div class="accordion" id="isoAccordion">
                        @foreach($standards as $key => $standard)
                            <div class="card">
                                <div class="card-header" id="isoHeading{{ $key }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#isoCollapse{{ $key }}" aria-expanded="false" aria-controls="isoCollapse{{ $key }}">
                                            {{ $standard->title }}
                                        </button>
                                    </h2>
                                </div>
                                <div id="isoCollapse{{ $key }}" class="collapse" aria-labelledby="isoHeading{{ $key }}" data-parent="#isoAccordion">
                                    <div class="card-body">{{ $standard->content }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <div id="contact" class="form-1 bg-dark-blue">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>! {{trans('.copyright')}}</h2>
                        @if($settings)
                            <ul class="list-unstyled li-space-lg">
                                @if($settings->address)
                                    <li class="media">
                                        <i class="fas fa-square"></i><div class="media-body"><strong>Address</strong> {{ $settings->address }}</div>
                                    </li>
                                @endif
                                @if($settings->phone)
                                    <li class="media">
                                        <i class="fas fa-square"></i><div class="media-body"><strong>Phone</strong> {{ $settings->phone }}</div>
                                    </li>
                                @endif
                                @if($settings->email)
                                    <li class="media">
                                        <i class="fas fa-square"></i><div class="media-body"><strong>Email</strong> {{ $settings->email }}</div>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <form id="registrationForm" action="{{ route('contactEmail') }}" method="post">
                        @csrf
                        @include('notifications')
                        <div class="form-group">
                            <input type="text" class="form-control-input" name="name">
                            <label class="label-control">{{trans('.Name')}}</label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input" name="email">
                            <label class="label-control">{{trans('.E-mail address')}}</label>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control-input" name="message"></textarea>
                            <label class="label-control">{{trans('.Message')}}</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">{{trans('.SEND')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
