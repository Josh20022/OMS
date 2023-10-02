@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit data</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('forms.show', $data->form_id) }}" class="btn btn-success mb-3">
                <i class="far fa-arrow-alt-circle-left"></i>
                Back to form
            </a>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data</h3>
                </div>
                <form action="{{ route('data.update', $data) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body" id="data-wrap"></div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('blade-scripts')
    <script>
        jQuery(function($) {
            "use strict";

            var formData = {!! json_encode($template) !!};
            const fbTemplate = $('#data-wrap');
            const formRender = fbTemplate.formRender({formData});

            $('#data-wrap input[type=file]').each(function() {
                let input = $(this).attr('id');
                let data = $('input[name=hidden-field-' + input + ']').attr('user-data');
                if(data) var array = JSON.parse(data);
                let html = "<p class='m-0 form_data_list mb-2'>";

                if(typeof array == 'string') {
                    html += "<a data-value='" + array + "' href='{{ $root }}" + array + "' target='_blank'><i class='fas fa-file'></i></a>" +
                        "<span data-id='" + input + "' data-value='" + array +"'><i class='fas fa-window-close text-danger'></i></span>";
                } else {
                    $(array).each( (key, value) => {
                        html += "<a data-value='" + value + "' href='{{ $root }}" + value + "' target='_blank'><i class='fas fa-file'></i></a>" +
                            "<span data-id='" + input + "' data-value='" + value +"'><i class='fas fa-window-close text-danger'></i></span>";
                    });
                }

                html += '</p>';
                $(html).insertBefore('#' + input);
            });
        });
    </script>
@endsection
