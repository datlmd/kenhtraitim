$(document).ready(function(){    
    var button = $('#btnAvatarUpload'), interval;

    new AjaxUpload(button, {
        action: base_url + 'films/admin_upload/avatar', 
        name: 'file_name_avatar',
        onSubmit : function(file, ext){
            // change button text, when user selects file			
            button.text('Uploading');

            // If you want to allow uploading only 1 file at time,
            // you can disable upload button
            this.disable();

            // Uploding -> Uploading. -> Uploading...
            interval = window.setInterval(function(){
                var text = button.text();
                if (text.length < 13){
                    button.text(text + '.');					
                } else {
                    button.text('Uploading');				
                }
            }, 200);
        },
        onComplete: function(file, response){
            button.text('Upload');

            window.clearInterval(interval);

            // enable upload button
            this.enable();
                       
            if ((response.substr(0, 11)) == '##SUCCESS##')
            {
                $('#btnAvatarUpload').hide();
                // get file_name
                var file_name = response.substr(11, response.length);
                // add file to the list
                $('input[name=avatar]').val(file_name);
                $('.image-medium-thum').show();
                $('.image-medium-thum').html('<img src="'+ img_url +'media/images/'+ getImageThumb(file_name, 'small_thumb') + '" />');
            } else 
            {
                jAlert('error', response, JsLang.ERROR);
            }
        }
    });
    
    // remove upload
    $('.JsAuthorCancelAvatar').livequery('click', function() {
        $('input[name=avatar]').val('');
        $('#btnAvatarUpload').show();
        $('#btnAvatarUpload').siblings('.image-medium-thum').hide();
    });
});