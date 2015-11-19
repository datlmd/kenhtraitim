$(document).ready(function(){    
	var jcrop_api, boundx, boundy;
	/* config */
    var button = $('#btnAvatarUpload'), interval;
    var button01 = $('#btnAvatarUpload01'), interval01;
    var url_upload = base_url + 'frontend/up_avatar';
    var uri_image = img_url +'media/images/';
    var input_name = 'image_name';
    var input_namett = 'image_namett';

    new AjaxUpload(button, {
        action: url_upload, 
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
            button.text('Chọn ảnh');

            window.clearInterval(interval);

            // enable upload button
            this.enable();
                       
            if ((response.substr(0, 11)) == '##SUCCESS##')
            {
                //$('#btnAvatarUpload').hide();
                // get file_name
                var file_name = response.substr(11, response.length);
                var temp = file_name.split('.');
                var temp_w = temp[1].split(' ');
                file_name = temp[0] + '_crop_495.' + temp_w[0];
                // add file to the list
                $('input[name='+input_name+']').val(file_name);
                $('#load_target').html('<img id="target" width="495" src="'+ uri_image + file_name + '" />');
                $('#load_preview').html('<img id="preview" alt="Preview" class="jcrop-preview" src="'+ uri_image + file_name + '" />');
                //$('#target').attr('src','http://localhost/f-idol/media/images/' + file_name);
                //$('#preview').attr('src','http://localhost/f-idol/media/images/' + file_name);
             
                
                $('#target').Jcrop({
                  onChange: updatePreview,
                  onSelect: updatePreview,
                  aspectRatio: 3/2
                },function(){
                  // Use the API to get the real image size
                  var bounds = this.getBounds();
                  boundx = bounds[0];
                  boundy = bounds[2];
                  // Store the API in the jcrop_api variable
                  jcrop_api = this;
                  jcrop_api.animateTo([0,0,300,190]);
                });
            } else 
            {
                alert('Upload thất bại vui lòng thử lại!');
            }
        }
    });
    new AjaxUpload(button01, {
        action: url_upload, 
        name: 'file_name_avatar',
        onSubmit : function(file, ext){
            // change button text, when user selects file			
    		button01.text('Uploading');

            // If you want to allow uploading only 1 file at time,
            // you can disable upload button
            this.disable();

            // Uploding -> Uploading. -> Uploading...
            interval01 = window.setInterval(function(){
                var text = button01.text();
                if (text.length < 13){
                	button01.text(text + '.');					
                } else {
                	button01.text('Uploading');				
                }
            }, 200);
        },
        onComplete: function(file, response){
        	button01.text('Chọn ảnh');

            window.clearInterval(interval01);

            // enable upload button
            this.enable();
                       
            if ((response.substr(0, 11)) == '##SUCCESS##')
            {
                //$('#btnAvatarUpload01').hide();
                // get file_name
                var file_name = response.substr(11, response.length);
                var temp = file_name.split('.');
                var temp_w = temp[1].split(' ');
                file_name = temp[0] + '_crop_495.' + temp_w[0];
                // add file to the list
                $('input[name='+input_namett+']').val(file_name);
                $('#load_targettt').html('<img id="targettt" width="495" src="'+ uri_image + file_name + '" />');
                $('#load_previewtt').html('<img id="previewtt" alt="Preview" class="jcrop-preview" src="'+ uri_image + file_name + '" />');
                //$('#target').attr('src','http://localhost/f-idol/media/images/' + file_name);
                //$('#preview').attr('src','http://localhost/f-idol/media/images/' + file_name);
             
                
                $('#targettt').Jcrop({
                  onChange: updatePreviewtt,
                  onSelect: updatePreviewtt,
                  aspectRatio: 1.7/3
                },function(){
                  // Use the API to get the real image size
                  var bounds = this.getBounds();
                  boundx = bounds[0];
                  boundy = bounds[2];
                  // Store the API in the jcrop_api variable
                  jcrop_api = this;
                  jcrop_api.animateTo([0,0,160,280]);
                });
            } else 
            {
                alert('Upload thất bại vui lòng thử lại!');
            }
        }
    });
    function updatePreview(c)
    {
    	$('#xp').val(c.x);
		$('#yp').val(c.y);
		$('#xp2').val(c.x2);
		$('#yp2').val(c.y2);
		$('#wp').val(c.w);
		$('#hp').val(c.h);
		
      if (parseInt(c.w) > 0)
      {
        var rx = 285 / c.w;
        var ry = 180 / c.h;

        $('#preview').css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
        
        
      }
    };
    
    function updatePreviewtt(c)
    {
    	$('#xptt').val(c.x);
		$('#yptt').val(c.y);
		$('#xptt2').val(c.x2);
		$('#yptt2').val(c.y2);
		$('#wptt').val(c.w);
		$('#hptt').val(c.h);
		
      if (parseInt(c.w) > 0)
      {
        var rx = 160 / c.w;
        var ry = 280 / c.h;

        $('#previewtt').css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
        
        
      }
    };
});