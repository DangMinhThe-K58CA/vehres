$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $('#side-menu').metisMenu();
    //Loads the correct sidebar on window load,
    //collapses the sidebar on window resize.
    // Sets the min-height of #page-wrapper to window size
    $(function() {
        $(window).bind("load resize", function() {
            topOffset = 50;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $('div.navbar-collapse').addClass('collapse');
                topOffset = 100; // 2-row-menu
            } else {
                $('div.navbar-collapse').removeClass('collapse');
            }

            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) height = 1;
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            }
        });

        var url = window.location;
        var element = $('ul.nav a').filter(function() {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
    });

    $('#changeAvatar').change(function (event) {
        previewImage(event.currentTarget, '.avatar');
    });

    $('select[name="province_id"]').change(function (event) {
        var curId = $(event.currentTarget).val();
        $.ajax({
            url :  laroute.action('App\Http\Controllers\AdministrationUnitController@getChildren'),
            method : 'GET',
            data : {'current_id' : curId, 'type' : 'district_id'},
            success : function (response) {
                $('#choseWard').addClass('hidden');
                $('#wardsField').html('');
                $('#districtsField').html(response);

                $('select[name="district_id"]').change(function (event) {
                    var curId = $(event.currentTarget).val();
                    $.ajax({
                        url :  laroute.action('App\Http\Controllers\AdministrationUnitController@getChildren'),
                        method : 'GET',
                        data : {'current_id' : curId, 'type' : 'ward_id'},
                        success : function (response) {
                            $('#choseWard').removeClass('hidden');
                            $('#wardsField').html(response);
                        }
                    });
                });
            }
        });
    });

    $('select[name="district_id"]').change(function (event) {
        var curId = $(event.currentTarget).val();
        $.ajax({
            url :  laroute.action('App\Http\Controllers\AdministrationUnitController@getChildren'),
            method : 'GET',
            data : {'current_id' : curId, 'type' : 'ward_id'},
            success : function (response) {
                $('#choseWard').removeClass('hidden');
                $('#wardsField').html(response);
            }
        });
    });

    $('#enableEditBtn').click(function (event) {
        event.preventDefault();
        var btn = $(event.currentTarget);
        var viewField = $('#viewsGarageField');
        var inputs = viewField.find('select, textarea, input:disabled');
        for (var i = 0; i < inputs.length; i ++) {
            var input = inputs[i];
            $(input).removeAttr('disabled');
        }
        $('img.avatar').closest('div').append('<br/><input id="changeAvatar" type="file" name="avatar" accept="image/*">');
        btn.removeClass('btn-primary');
        btn.addClass('btn-success');
        btn.text('Update');
        btn.off('click');
        btn.attr('type', 'submit');

        $('#changeAvatar').on('change', function (event) {
            previewImage(event.currentTarget, '.avatar');
        });
    });

    if ($('.textAreaForEditorField').length !== 0) {
        CkEditorInit('contentEditor');
    }
});

function CkEditorInit(name) {
    if (CKEDITOR.instances[name])
    {
        CKEDITOR.instances[name].destroy();
    }
    CKupdate;
    CKEDITOR.replace(name);
}

function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}

function previewImage(input, previewFieldId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var previewField = $(previewFieldId);
            previewField.removeClass('hidden');
            previewField.attr('src', e.target.result).attr('width', '100%');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click', '.closeModalBtn', function (event) {
    window.location.reload();
});
