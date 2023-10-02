@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Expanded form data</h1>
                    @include('dashboard.notifications')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('forms.show', $id) }}" class="btn btn-success mb-3">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Back to form
                    </a>
                </div>
                <div class="col-12">
                    <div class="card card-primary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Expand other data</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('form.data', $id) }}" method="get">
                                <div class="form-group">
                                    <label>Fields</label>
                                    <select class="custom-select rounded-0" name="field">
                                        <option value="">Select field</option>
                                        @foreach($excludedArray as $value)
                                            <option value="{{ $value['name'] }}">{{ $value['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Data expanded by
                                <span class="bg-light expanded_label">{{ $fields[$firstKey]->data[$key]['label'] }}</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="expandedData">
                                @foreach($fields as $field)
                                    <div class="card">
                                        <div class="card-header">
                                            <h2>
                                                <button class="btn btn-block text-left d-flex" type="button" data-toggle="collapse" data-target="#data{{ $field->id }}" aria-expanded="false">
                                                    <div class="btn btn-app mr-3">
                                                        <b>{{ $users[$field->user_id] }}</b><br>
                                                        <span class="text-xs">{{ date_format($field->created_at, 'd M Y') }}</span>
                                                    </div>
                                                    <div>
                                                        @php
                                                            $class = "";
                                                            if(strpos($field->data[$key]['name'], 'date') !== false && $field->data[$key]['value'] !== 'N/A') {
                                                                $fieldDate = new DateTime($field->data[$key]['value']);
                                                                $now = new DateTime();

                                                                if($now > $fieldDate) {
                                                                    $class = 'btn bg-danger';
                                                                } elseif($fieldDate->diff($now)->days < 30) {
                                                                    $class = 'btn bg-orange';
                                                                } else {
                                                                    $class = 'btn bg-success';
                                                                }
                                                            }
                                                        @endphp
                                                        @if(strpos($field->data[$key]['name'], 'file') !== false)
                                                            <p class="m-0 form_data_list">
                                                                @if(is_array($field->data[$key]['value']))
                                                                    @if(!empty($field->data[$key]['value']))
                                                                        @foreach($field->data[$key]['value'] as $value)
                                                                            <a href="{{ route('media', ['userId' => $field->user_id, 'slug' => $value]) }}" target="_blank">
                                                                                <i class="fas fa-file"></i>
                                                                            </a>
                                                                        @endforeach
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                @else
                                                                    @if($field->data[$key]['value'] !== "N/A")
                                                                        <a href="{{ route('media', ['userId' =>$field->user_id, 'slug' => $field->data[$key]['value']]) }}" target="_blank">
                                                                            <i class="fas fa-file"></i>
                                                                        </a>
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                @endif
                                                            </p>
                                                        @else
                                                            @if(is_array($field->data[$key]['value']))
                                                                @foreach($field->data[$key]['value'] as $value)
                                                                    <p class="m-0">{{ $value }}</p>
                                                                @endforeach
                                                            @else
                                                                <p class="m-0 {{ $class }}">{{ $field->data[$key]['value'] }}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="data{{ $field->id }}" class="collapse" data-parent="#expandedData">
                                            <div class="card-body">
                                                @php $newFields = $field->data; unset($newFields[$key]) @endphp
                                                <table class="table table-hover form_data_table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        @foreach($newFields as $newField)
                                                            <th>{{ $newField['label'] }}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($newFields as $newField)
                                                            @php
                                                                $class = "";
                                                                if(strpos($newField['name'], 'date') !== false && $newField['value'] !== 'N/A') {
                                                                    $fieldDate = new DateTime($newField['value']);
                                                                    $now = new DateTime();

                                                                    if($now > $fieldDate) {
                                                                        $class = 'text-center bg-danger';
                                                                    } elseif($fieldDate->diff($now)->days < 30) {
                                                                        $class = 'text-center bg-orange';
                                                                    } else {
                                                                        $class = 'text-center bg-success';
                                                                    }
                                                                }
                                                            @endphp
                                                            <td class="{{ $class }}">
                                                                @if(strpos($newField['name'], 'file') !== false)
                                                                    <p class="m-0 form_data_list">
                                                                        @if(is_array($newField['value']))
                                                                            @if(!empty($newField['value']))
                                                                                @foreach($newField['value'] as $value)
                                                                                    <a href="{{ route('media', ['userId' => $field->user_id, 'slug' => $value]) }}" target="_blank">
                                                                                        <i class="fas fa-file"></i>
                                                                                    </a>
                                                                                @endforeach
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        @else
                                                                            @if($newField['value'] !== "N/A")
                                                                                <a href="{{ route('media', ['userId' =>$field->user_id, 'slug' => $newField['value']]) }}" target="_blank">
                                                                                    <i class="fas fa-file"></i>
                                                                                </a>
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        @endif
                                                                    </p>
                                                                @else
                                                                    @if(is_array($newField['value']))
                                                                        @foreach($newField['value'] as $value)
                                                                            <p class="m-0">{{ $value }}</p>
                                                                        @endforeach
                                                                    @else
                                                                        <p class="m-0">{{ $newField['value'] }}</p>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
