@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create form</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div id="build-wrap">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" id="formTitle" class="form-control" placeholder="Form title" name="title">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Assigned users</label>
                            <select class="custom-select rounded-0" name="users[]" id="formUser" multiple>
                                <option value="">Select user</option>
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Publish form</label>
                        <div class="form-control checkbox_wrap">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="formPublish" name="publish">
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
                onSave: function(evt, formData) {
                    var title = $("input#formTitle").val();
                    var error = "";

                    if(formData.length < 2 || title.length < 1) {
                        error = "<div class='error_callout callout callout-danger mt-4'>" +
                            "<span><i class='fas fa-window-close text-lg text-danger'></i></span>" +
                            "<p>Form title and form are required.</p>" +
                            "</div>";

                        $(error).insertAfter(".content-header h1");
                    }

                    if(!error) {
                        var publish = $("input#formPublish").is(":checked");
                        var users = $("#formUser").select2('val');

                        axios.post('/dashboard/forms', { title: title, users: users, template: formData, publish: publish })
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

            const fbTemplate = document.getElementById('build-wrap');
            $(fbTemplate).formBuilder(options);
        });
    </script>
@endsection
