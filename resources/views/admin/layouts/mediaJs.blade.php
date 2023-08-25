<!-- Modal -->
<div class="modal fade" id="lightBox" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                   <div class="imageCanvas">
                    <img class="imgPrev" id="previewImage" src="" class="w-100">
                   </div>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";
    localStorage.clear();
    let images = [];
    function storeImage(data) {
        data = data.split(",");
        let input_selector = JSON.parse(localStorage.input_selector);
        localStorage['images_' + input_selector] = JSON.stringify(data);
        setImage(preview('col-md-2', input_selector));
    }
    function setImage(img) {
        $('#selected_images').html(img);
    }
    $("[data-module='media-manager']").on('click', function() {
        let data = $(this).attr("data-input");
        localStorage.input_selector = JSON.stringify(data);
        localStorage.multi_select = JSON.stringify($(this).attr("data-multi-select"));
    });
    $('#custom_button').on('click', function() {
        let input_selector = JSON.parse(localStorage.input_selector);
        let data = JSON.parse(localStorage['images_' + input_selector]).toString();
        $("[data-media=" + input_selector + "]").val(data);
        $("[data-preview=" + input_selector + "]").html(preview('col-md-3', input_selector));
    });
    function preview(size, input_selector) {
        return jQuery.map(getData(input_selector), function(image, index) {
            return `
                <div class="${size} mb-4 mt-4">
                    <div class="w-100">
                        <img class="w-100" src="{{url('/')}}/${image}"/>
                        <i onclick="removeImage(this)" class="fas fa-times-circle" data-image="${image}"  data-storage="${input_selector}"></i>
                        ${ index === 0 ? '<span class="type bg-primary"> main </span>' : ''}
                    </div>
                </div>
                `;
        });
    }
    function getData(input_selector) {
        return JSON.parse(localStorage['images_' + input_selector]);
    }
    function setData(image) {
        let input_selector = JSON.parse(localStorage.input_selector);
        let data = [];
        if (JSON.parse(localStorage.multi_select) == "1") {
            if (localStorage['images_' + input_selector]) {
                data = JSON.parse(localStorage['images_' + input_selector]);
            }
            data.push(image);
            localStorage['images_' + input_selector] = JSON.stringify(data);
        } else {
            data.push(image);
            localStorage['images_' + input_selector] = JSON.stringify(data);
        }
    }
    function removeImage(this_) {
        let storage = $(this_).attr("data-storage");
        let image = $(this_).attr("data-image");
        let selectedImages = JSON.parse(localStorage['images_' + storage]);
        selectedImages.splice($.inArray(image, selectedImages), 1);
        localStorage['images_' + storage] = JSON.stringify(selectedImages);
        let data = selectedImages.toString();
        $("[data-media=" + storage + "]").val(data);
        setImage(preview('col-md-2', storage));
        $("[data-preview=" + storage + "]").html(preview('col-md-3', storage));
    }
    $('#formId').on('submit', (function(e) {
        e.stopImmediatePropagation();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            enctype: 'multipart/form-data',
            type: 'POST',
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.progress-bar').css('width', percentComplete + '%');
                        if (percentComplete === 100) {
                            setTimeout(function() {
                                $('.progress-bar').css('width', '0%');
                            }, 2000);
                        }
                    }
                }, false);
                return xhr;
            },
            url: "<?= route('admin.mediaupload') ?>",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.img_status == 'uploaded' && data.name_status == 'exist') {
                    let query = $('#search').val();
                    fetch_data(1, query);
                    $('#inputGroupFile').val(null);
                    $('.custom-file-label').html('Choose file');
                    $('#file-name').val(null);
                    Toast.fire({
                        icon: 'success',
                        title: '{{trans('admin.Image uploaded!')}}'
                    });
                }
                if (data.img_status == 'notselected') {
                    $('.custom-file-label').html(
                        '{{trans('admin.Please select an image!')}}');
                    Toast.fire({
                        icon: 'error',
                        title: '{{trans('admin.Image not selected!')}}'
                    });
                }
                if (data.name_status == 'missing') {
                    $('#file-name').attr("placeholder",
                        "{{trans('admin.File name required!')}}");
                    Toast.fire({
                        icon: 'error',
                        title: '{{trans('admin.File name required!')}}'
                    });
                }
            },
            error: function(data) {
            }
        });
    }));
    $('#inputGroupFile').on('change', function() {
        //get the file name
        let fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });
    // Fetch Files
    $('#image-select').click(function() {
        let query = $('#search').val();
        fetch_data(1, query);
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let query = $('#search').val();
            let page = $(this).attr('href').split('page=')[1];
            fetch_data(page, query);
        });
        $('#search').on('keyup', function() {
            let query = $('#search').val();
            fetch_data(1, query);
        });
    });
    $(document).ready(function() {
        let query = $('#search').val();
        fetch_data(1, query);
        $(document).on('click', '.pagination a', function(event) {
            event.stopPropagation();
            event.preventDefault();
            let query = $('#search').val();
            let page = $(this).attr('href').split('page=')[1];
            fetch_data(page, query);
        });
        $('#search').on('keyup', function(event) {
            event.stopPropagation();
            let query = $('#search').val();
            fetch_data(1, query);
        });
    });
    function fetch_data(page, query) {
        $.ajax({
            url: "<?= route('admin.mediaimages') ?>?page=" + page + "&query=" + query,
            success: function(data) {
                $('#table_data').html(data);
                $('.custom-control-input').on('click', function() {
                    const image = $(this).val();
                    let input_selector = JSON.parse(localStorage.input_selector);
                    if (images.length === 0) {
                        images.push(image);
                        localStorage['images_' + input_selector] = JSON.stringify(images);
                    } else {
                        setData(image);
                    }
                    setImage(preview('col-md-2', input_selector));
                });
            }
        });
    }
    $('#delete_button').on('click', function() {
        var value = $('input[name=image]:checked').attr('id');
        $.ajax({
            url: "{{route('admin.media.delete')}}?id=" + value,
            success: function(data) {
                if (data.status == 'deleted') {
                    var query = $('#search').val();
                    fetch_data(1, query);
                    $("#custom_button").attr("disabled", true);
                    $('#alert').addClass('d-block show');
                    setTimeout(function() {
                        $('#alert').removeClass('d-block show');
                        $('#alert').addClass('d-none');
                    }, 2000);
                }
            }
        });
    });
    $("form").submit(function(event) {
        let valid = true;
        event.preventDefault();
        var text = $('form');
        var Validator = text.find('input[id=form-image]').each(function() {
            if (!$(this).val()) {
                Validate($(this).attr('data-title') + ' is Required');
                valid = false;
            }
        });
        if (valid == true) {
            $(this).unbind('submit').submit();
        }
    });
    async function Validate(data) {
        await Toast.fire({
            icon: 'error',
            timer: 3000,
            title: data,
        });
    }
   function lightBox(img){
    $('#lightBox').modal('show');
    $('#previewImage').attr("src",img);
    }
</script>
