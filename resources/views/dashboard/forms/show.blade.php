@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#info" role="tab" aria-selected="true">Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#template" role="tab" aria-selected="false">Template</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#data" role="tab" aria-selected="false">Data</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="info" role="tabpanel">
                                    <div class="col-3">
                                        <h2 class="lead">{{ $form->title }}</h2>
                                        <hr>
                                        <p class="text-muted text-sm">
                                            <b>Assigned to: </b>
                                            {{ count($form->users) > 0 ? implode(', ', $form->users->pluck('name')->toArray()) : 'Unassigned' }}
                                        </p>
                                        <p class="text-muted text-sm">
                                            <b>Created: </b>
                                            {{ date_format($form->created_at, 'd M Y') }}
                                        </p>
                                        <p class="text-muted text-sm">
                                            <b>Publish: </b>
                                            {!! $form->getPublishIcon() !!}
                                        </p>
                                        <hr>
                                    </div>
                                    <div class="col-12">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td class="pb-2">
                                                    <a href="{{ route('forms.edit', $form) }}" class="btn btn-primary btn-flat">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-flat form_delete" data-id="{{ $form->id }}" data-name="{{ $form->title }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="template" role="tabpanel">
                                    <div class="col-md-6">
                                        <div id="template-wrap"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="data" role="tabpanel">
                                    @if(count($form->data) > 0)
                                        @php
                                            $fields = $form->data;
                                            $firstKey = array_key_first($fields->toArray())
                                        @endphp
                                        <form action="{{ route('form.data', $form->id) }}" method="get" class="container-fluid">
                                            <label for="">Select field to expand data</label>
                                            <div class="row" class="form-group">
                                                <div class="col">
                                                    <select class="custom-select rounded-0" name="field">
                                                        <option value="">Select field</option>
                                                        @foreach($fields[$firstKey]->data as $field)
                                                            <option value="{{ $field['name'] }}">{{ $field['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary">Expand</button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <x-form-data :fields="$fields" :users="$users"/>
                                    @else
                                        <p>
                                            <i class="fas fa-exclamation text-danger text-lg pr-2"></i>
                                            No data filled by users.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
