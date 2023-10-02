jQuery(function($) {
    "use strict";

    // Init custom file input
    $(function () {
        bsCustomFileInput.init();
    });

    // Select 2
    $("#formUser, #pageUser").select2({
        placeholder: "Select users",
        allowClear: true
    });

    // Close notification callout
    $(document).on('click', '.error_callout span', function(e) {
        $(this).parents('.error_callout').fadeOut();
    });

    // Remove avatar
    $('.remove_avatar').click(function() {
        $('#removeAvatar').val('remove_avatar');
        $('.edit_avatar').remove();
    });

    // Delete client/user
    $(document).on('click', '.client_delete', function(e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        if($(this).hasClass('user_delete')) {
            var route = 'user_delete';
        } else {
            var route = '';
        }

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete <b>" + name + "</b> from the system?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_delete btn btn-danger btn-sm "+route+"' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_delete', function(e) {
        let id = $(this).attr('data-id');
        if($(this).hasClass('user_delete')) {
            var route = 'users';
        } else {
            var route = 'clients';
        }

        axios.delete('/dashboard/' + route + '/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete language/user
    $(document).on('click', '.lang_delete', function(e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        var route = '';
        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete <b>" + name + "</b> from the system?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_delete btn btn-danger btn-sm "+route+"' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_delete', function(e) {
        let id = $(this).attr('data-id');
        var route = 'languages';

        axios.delete('/dashboard/' + route + '/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete form
    $(document).on('click', '.form_delete', function(e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete <b>" + name + "</b> form?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_form_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_form_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/forms/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete page
    $(document).on('click', '.page_delete', function(e) {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete <b>" + name + "</b> page?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_page_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_page_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/pages/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete ISO
    $(document).on('click', '.iso_delete', function(e) {
        let id = $(this).attr('data-id');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete current ISO standard?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_iso_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_iso_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/isos/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete slide
    $(document).on('click', '.slide_delete', function(e) {
        let id = $(this).attr('data-id');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete current slide?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_slide_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_slide_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/slides/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete method
    $(document).on('click', '.method_delete', function(e) {
        let id = $(this).attr('data-id');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete current method?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_method_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_method_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/methods/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete advantage
    $(document).on('click', '.advantage_delete', function(e) {
        let id = $(this).attr('data-id');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete current advantage?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_advantage_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_advantage_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/advantages/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Delete data
    $(document).on('click', '.data_delete', function(e) {
        let id = $(this).attr('data-id');

        let html = "<div class='delete_note_wrap callout callout-info ml-2'>" +
            "Are you sure you want to delete current data?" +
            "<button type='button' class='cancel_delete btn btn-info btn-sm mr-2 ml-4'>Cancel</button>" +
            "<button type='button' class='confirm_data_delete btn btn-danger btn-sm' data-id='"+id+"'>Confirm</button>" +
            "</div>";

        $(this).parents('tr').after(html);
    });

    $(document).on('click', '.confirm_data_delete', function(e) {
        let id = $(this).attr('data-id');

        axios.delete('/dashboard/data/' + id)
            .then((response)=>{
                if(response.data.status) {
                    window.location.href = response.data.url;
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Cancel client/user/form/page/ISO/slide/method/advantage/data delete
    $(document).on('click', '.cancel_delete', function(e) {
        $(this).parents('.delete_note_wrap').remove();
    });

    // TinyMCE Page Content
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.init({
        selector: 'textarea#pageContent',
        deprecation_warnings: false,
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: function (callback, value, meta) {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
            }
        },
        templates: [
            { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
            { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
            { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/dashboard/pages/file-upload');
            xhr.setRequestHeader("X-CSRF-Token", $('input[name=_token]').val());
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                console.log(json.location);
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        convert_urls: false
    });

    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    tinymce.init({
        selector: 'textarea.pageContent',
        deprecation_warnings: false,
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: function (callback, value, meta) {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
            }
        },
        templates: [
            { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
            { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
            { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/dashboard/pages/file-upload');
            xhr.setRequestHeader("X-CSRF-Token", $('input[name=_token]').val());
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                console.log(json.location);
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        convert_urls: false
    });


    // TinyMCE Welcome Text
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.init({
        selector: 'textarea#welcomeText',
        deprecation_warnings: false,
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: function (callback, value, meta) {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
            }
        },
        templates: [
            { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
            { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
            { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 465,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/dashboard/pages/file-upload');
            xhr.setRequestHeader("X-CSRF-Token", $('input[name=_token]').val());
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                console.log(json.location);
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        convert_urls: false
    });

    // Draggable orders
    $(function() {
        $("#form-").sortable({
            revert: true
        });

        $("#draggable").draggable({
            connectToSortable: "#form-",
            helper: "clone",
            revert: "invalid"
        });

        $("ul, li").disableSelection();
    });

    $(function() {
        $("#page-documentation").sortable({
            revert: true
        });

        $("#draggable").draggable({
            connectToSortable: "#page-documentation",
            helper: "clone",
            revert: "invalid"
        });

        $("ul, li").disableSelection();
    });

    $(function() {
        $("#page-registration").sortable({
            revert: true
        });

        $("#draggable").draggable({
            connectToSortable: "#page-registration",
            helper: "clone",
            revert: "invalid"
        });

        $("ul, li").disableSelection();
    });

    $(function() {
        $("#page-report").sortable({
            revert: true
        });

        $("#draggable").draggable({
            connectToSortable: "#page-report",
            helper: "clone",
            revert: "invalid"
        });

        $("ul, li").disableSelection();
    });

    $(function() {
        $(".sub_drag").sortable({
            revert: true
        });

        $("#draggable").draggable({
            connectToSortable: ".sub_drag",
            helper: "clone",
            revert: "invalid"
        });
    });

    // Store draggable order
    $(document).on('click', '.set_order_btn', function(e) {
        var html = "<span class='order_update_note'>Order updated.</span>";
        var user_id = $(this).attr('data-user');
        var type = $(this).attr('data-type');
        var category = $(this).attr('data-category');
        var order = {};

        $('#' + type + '-' + category + ' li').each(function() {
            var title = $(this).attr('data-title');
            var id = parseInt($(this).attr('data-id'));
            order[' ' + id] = title;
        });

        axios.post('/dashboard/order', { user_id: user_id, type: type, category: category, ids: order })
            .then((response)=>{
                if(response.data.status) {
                    $(html).insertAfter($(this)).delay(1300).fadeOut('slow');
                }
            }).catch((error)=>{
            console.log(error);
        });
    });

    // Date filter
    $(document).on('click', '.date_filter', function(e) {
        $('.date_filter').removeClass('selected');
        $(this).addClass('selected');
        var filter = $(this).attr('data-date');

        if(filter) {
            $('.form_data_table tbody tr').each(function() {
                if($(this).children().hasClass(filter)) {
                    $(this).fadeIn();
                } else {
                    $(this).fadeOut();
                }
            });
        } else {
            $('.form_data_table tbody tr').fadeIn();
        }
    });

    // Remove image on data edit
    $(document).on('click', '#data-wrap .form_data_list span', function(e) {
        let id = $(this).attr('data-id');
        let value = $(this).attr('data-value');
        let data = $('input[name=hidden-field-' + id + ']').val();
        let array = JSON.parse(data);

        if(typeof array == 'string') {
            var newValue = '';
        } else {
            let newArray = $.grep(array, function(n) {
                return n != value;
            });

            var newValue = JSON.stringify(newArray);
        }

        $('input[name=hidden-field-' + id + ']').attr('value', newValue);
        $(this).remove();
        $('a[data-value="' + value + '"]').remove();
    });

});
