(function(){
    var profile_image = "{{ $user->avatar ?? null }}";
    var storagePath = "{{asset('/storage/thumb')}}";

    jQuery(document).ready(function () {
        jQuery("[name='avatar']").change(function (e) {
            readURL(this);
        });

        if (profile_image) {
            jQuery('#upload-holder').css({
                'background-image': 'url(' + storagePath + "/" + profile_image + ')',
                'background-size': 'cover',
            }).hide().fadeIn(650);
        }

        jQuery('#password_confirmation').on('blur', function () {
            validateForm();
        });
    });

    function validateForm(){
        let $passElem = jQuery('#password'),
            $confirmPassElem = jQuery('#password_confirmation');
        if($passElem.val() != ''){
            $errorElem = $confirmPassElem.closest('.form-group').find('.field_error');
            if($passElem.val() != $confirmPassElem.val()){
                $errorElem.html('Your confirm password does not match')
                return false;
            }else{
                $errorElem.html('');
            }
        }
        return true;
    }

    function fileValidate(files, fileTypes) {
        var extension = files.name.split('.').pop().toLowerCase();
        return fileTypes.indexOf(extension) > -1;
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var fileTypes = ['png', 'jpg', 'jpeg', 'gif'];
            var isSuccess = fileValidate(input.files[0], fileTypes);
            if (isSuccess) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    jQuery('#upload-holder').css({
                        'background-image': 'url(' + e.target.result + ')',
                        'background-size': 'cover',
                    }).hide().fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                toast.error('Wrong file format, Please upload only png,jpg and gif files');
            }
        }
    }
})();