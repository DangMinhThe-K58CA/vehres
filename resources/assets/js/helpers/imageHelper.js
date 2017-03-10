export default function previewImage(input, previewFieldId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var previewField = $('#' + previewFieldId);
            previewField.removeClass('hidden');
            previewField.children('img').attr('src', e.target.result).attr('width', '75%');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
