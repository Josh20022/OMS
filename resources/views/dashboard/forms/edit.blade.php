@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit form</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div id="edit-wrap">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" id="formTitle" class="form-control" placeholder="Form title" name="title" value="{{ $form->title }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Assigned users</label>
                            <select class="custom-select rounded-0" name="users[]" id="formUser" multiple>
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}" @if(in_array($id, $assignedUsers)) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Publish form</label>
                        <div class="form-control checkbox_wrap">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="formPublish" name="publish" @if($form->publish) checked @endif>
                                <label for="formPublish" class="custom-control-label">Check for publishing</label>
                            </div>
                        </div>
                    </div>
                </div>
                <label>Form</label>
            </div>
        </div>
    </section>
@endsection

@section('blade-scripts')
    <script>
        jQuery(function($) {
            "use strict";

            var options = {
                formData : {!! json_encode($form->template) !!},
                onSave: function(evt, formData) {
                    var title = $( "input#formTitle" ).val();
                    var error = "";

                    if(formData.length < 2 || title.length < 1) {
                        error = "<div class='error_callout callout callout-danger mt-4'>" +
                            "<span><i class='fas fa-window-close text-lg text-danger'></i></span>" +
                            "<p>Form title and form are required.</p>" +
                            "</div>";

                        $(error).insertAfter(".content-header h1");
                    }

                    if(!error) {
                        var id = {{ $form->id }};
                        var users = $("#formUser").select2('val');
                        var publish = $("input#formPublish").is(":checked");

                        axios.put('/dashboard/forms/' + id, { title: title, users: users, template: formData, publish: publish })
                        .then((response)=>{
                            if(response.data.status) {
                                window.location.href = response.data.url;
                            }
                        }).catch((error)=>{
                            console.log(error);
                        });
                    }
                },
            };

            const fbTemplate = document.getElementById('edit-wrap');
            $(fbTemplate).formBuilder(options);
        });
    </script>
@endsection
