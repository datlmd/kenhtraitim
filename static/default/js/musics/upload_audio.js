$(document).ready(function(){    
    var button = $('#btnMp3Upload'), interval;

    new AjaxUpload(button, {
        action: base_url + 'musics/admin_upload/audio', 
        name: 'file_name_audio',
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
            var rlength = $(response).find('length').text();
            var rbitrate = $(response).find('bitrate').text();
            
                       
            if (rstatus == 0)
            {
                $('#btnMp3Upload').hide();                                
                
                // add file to the list
                $('input[name=file]').val(rfile);
                $('input[name=length]').val(rlength);
                $('input[name=hight_quality]').val(rbitrate);
                $('#btnMp3Upload').siblings('.JsFileUpload').html('<div class="line">' + file + '</div>');
            } else 
            {
                jAlert('error', rmessage, JsLang.ERROR);
            }
        }
    });
    
    // remove upload
    $('.JsAuthorCancelAudio').livequery('click', function() {
        $('input[name=file]').val('');
        $('#btnMp3Upload').show();
        $('#btnMp3Upload').siblings('.JsFileUpload').hide();
    });
});