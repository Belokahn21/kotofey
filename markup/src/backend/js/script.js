$(document).ready(function () {
    $('.preview-image-wrap').previewImage();
});


$.fn.previewImage = function () {

    this.each(function () {
        var $file_input = $(this).find('input[type=file]'),
            $images_container = $(this).find('.preview-image');

        if ($file_input.length === 0) {
            return false;
        }

        $file_input.on('change', function () {
            var thisInput = this;
            if ($images_container.length === 0) {
                return false;
            }
            $images_container.html('');
            if (thisInput.files) {
                for (var i = 0; i < thisInput.files.length; i++) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $images_container.append($('<img />', {
                            src: e.target.result
                        }));
                    };
                    reader.readAsDataURL(thisInput.files[i]);
                }

            }

        });
    });
};
