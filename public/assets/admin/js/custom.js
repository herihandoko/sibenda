/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function convertToSlug(Text) {
    return Text.toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
}
$('[name="title"]').on('input', function () {
    $('[name="slug"]').val(convertToSlug($(this).val()));
})

$('[name="name"]').on('input', function () {
    $('[name="slug"]').val(convertToSlug($(this).val()));
})


tinymce.init({
    selector: 'textarea#editor',
});

$(function() {
    $('select').select2();
});


