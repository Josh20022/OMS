@extends('layout')

@section('title')
    Form | WE Management
@endsection

@section('content')
    <section id="formSection">
        <div class="container">
            <div class="tab_header d-flex" style="background-color: {{ auth()->user()->bg_color }}">
                <h5 class="card-title m-0" style="color: {{ auth()->user()->text_color }}">{{ $form->title }}</h5>
            </div>
            @if(count($form->data->where('user_id', auth()->id())) > 0)
                <div class="form_data">
                    @include('notifications')
                    <button
                        style="background-color: {{ auth()->user()->bg_color }}; color: {{ auth()->user()->text_color }}"
                        class="text-uppercase profile_edit_btn"
                        type="button"
                        data-toggle="collapse"
                        data-target="#editForm"
                    >
                        Form
                    </button>
                    <div class="collapse" id="editForm">
                        <div class="card card-body">
                            <form
                                action="{{ url(getProtocol() . auth()->user()->subdomain . '.' . getDomain() . '/form/' . $form->id) }}"
                                method="post"
                                enctype="multipart/form-data"
                                class="form_data"
                            >
                                @csrf
                                <div id="template-wrap"></div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    @php
                        $fields = $form->data->where('user_id', auth()->id());
                        $users = [auth()->id() => auth()->user()->name];
                    @endphp
                    <x-form-data :fields="$fields" :users="$users"/>
                </div>
            @else
                <form
                    action="{{ url(getProtocol() . auth()->user()->subdomain . '.' . getDomain() . '/form/' . $form->id) }}"
                    method="post"
                    enctype="multipart/form-data"
                    class="form_data"
                >
                    @csrf
                    <div id="template-wrap"></div>
                </form>
            @endif
        </div>
    </section>
@endsection

@section('blade-scripts')
    <script>
        jQuery(function($) {
            "use strict";

            var formData = {!! json_encode($form->template) !!};
            const fbTemplate = document.getElementById('template-wrap');
            $(fbTemplate).formRender({formData});
        });
    </script>
@endsection

