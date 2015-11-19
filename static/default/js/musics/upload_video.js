$(document).ready(function(){    
    var button = $('#btnVideoUpload'), interval;

    new AjaxUpload(button, {
        action: base_url + 'musics/admin_upload/video', 
        name: 'file_name_video',
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
            
            var rstatus = $(response).find('status').text();
            var rmessage = $(response).find('message').text();
            var rfile = $(response).find('file').text();
            var ravatar = $(response).find('avatar').text();
            var rlength = $(response).find('length').text();
            var rbitrate = $(response).find('bitrate').text();
            
                       
            if (rstatus == 0)
            {
                $('#btnVideoUpload').hide();                                
                
                // add file to the list
                $('input[name=file]').val(rfile);
                $('input[name=avatar]').val(ravatar);
                $('input[name=length]').val(rlength);
                $('input[name=hight_quality]').val(rbitrate);
                $('.JsVideoAvatar .image-medium-thum').html('<img src="'+ img_url +'media/images/'+ getImageThumb(ravatar, 'small_thumb') + '" />');
                $('#btnVideoUpload').siblings('.JsFileUpload').html('<div class="line">' + file + '</div>');
            } else 
            {
                jAlert('error', rmessage, JsLang.ERROR);
            }
        }
    });
    
    // remove upload
    $('.JsAuthorCancelVideo').livequery('click', function() {
        $('input[name=file]').val('');
        $('#btnVideoUpload').show();
        $('#btnVideoUpload').siblings('.JsFileUpload').hide();
    });
});