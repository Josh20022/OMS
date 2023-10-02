@php $firstKey = array_key_first($fields->toArray()) @endphp
<div class="card">
    @if(str_contains(url()->current(), 'dashboard'))
        <div class="card-header">
            <span class="card-title">Filter date:</span>
            <span class="date_filter selected" data-date=""><i class="far fa-square"></i></span>
            <span class="date_filter" data-date="bg-success"><i class="fas fa-square text-success"></i></span>
            <span class="date_filter" data-date="bg-orange"><i class="fas fa-square text-orange"></i></span>
            <span class="date_filter" data-date="bg-danger"><i class="fas fa-square text-danger"></i></span>
        </div>
    @endif
    <div class="card-body table-responsive p-0">
        <table class="table table-hover form_data_table">
            <thead>
                <tr>
                    @if(str_contains(url()->current(), 'dashboard'))
                        <th class="bg-light" style="border-right: 1px solid rgba(0, 0, 0, .1)"></th>
                        <th class="bg-light">User<br><span class="text-xs">Submit date</span></th>
                    @endif
                    @foreach($fields[$firstKey]->data as $field)
                        <th>{{ $field['label'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($fields as $field)
                    <tr>
                        @if(str_contains(url()->current(), 'dashboard'))
                            <td class="bg-light actions_td">
                                <div class="actions_btn_wrap">
                                    <div>
                                        <a href="{{ route('data.edit', $field) }}">
                                            <i class="far fa-edit text-primary"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="data_delete" data-id="{{ $field->id }}">
                                            <i class="far fa-trash-alt text-danger"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="bg-light">
                                <b>{{ $users[$field->user_id] }}</b><br>
                                <span class="text-xs">{{ date_format($field->created_at, 'd M Y') }}</span>
                            </td>
                        @endif
                        @foreach($field->data as $fieldData)
                            @php
                                $class = "";
                                if(strpos($fieldData['name'], 'date') !== false && $fieldData['value'] !== 'N/A') {
                                    $fieldDate = new DateTime($fieldData['value']);
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
                                @if(strpos($fieldData['name'], 'file') !== false)
                                    <p class="m-0 form_data_list">
                                        @if(is_array($fieldData['value']))
                                            @if(!empty($fieldData['value']))
                                                @foreach($fieldData['value'] as $value)
                                                    <a href="{{ route('media', ['userId' => $field->user_id, 'slug' => $value]) }}" target="_blank">
                                                        <i class="fas fa-file"></i>
                                                    </a>
                                                @endforeach
                                            @else
                                                N/A
                                            @endif
                                        @else
                                            @if($fieldData['value'] !== "N/A")
                                                <a href="{{ route('media', ['userId' =>$field->user_id, 'slug' => $fieldData['value']]) }}" target="_blank">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        @endif
                                    </p>
                                @else
                                    @if(is_array($fieldData['value']))
                                        @foreach($fieldData['value'] as $value)
                                            <p class="m-0">{{ $value }}</p>
                                        @endforeach
                                    @else
                                        <p class="m-0">{{ $fieldData['value'] }}</p>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
