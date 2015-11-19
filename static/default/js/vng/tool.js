/* 
 * @namespace JS Framework
 * @author danhdvd <danhdvd@yahoo.com>
 * @copyright Đoàn Vũ Đình Danh 2012
 * 
 * @name Tools
 * @type Javascript
 * @description Support helpful tools
 * @property Optional 7
 * 
 */

//config

//constanse
var TOOL_PLAYER_VIDEO_JWPLAYER = CONFIG_DVD_PREFIX + "tool_player_video_jwplayer";
var TOOL_FLASH_OBJECT = CONFIG_DVD_PREFIX + "tool_flash_object"; 

$(document).ready(function(){
    
    if(dvd_is_exist($(TOOL_PLAYER_VIDEO_JWPLAYER)))
    {
        $(TOOL_PLAYER_VIDEO_JWPLAYER).each(function(){
            jwplayer($(this).attr('id')).setup({
                'flashplayer': CONFIG_URL_STATIC_FRONTEND + 'js/jwplayer/player.swf',
                'file': CONFIG_URL_MEDIA + 'videos/' + $(this).attr(CONFIG_ATTR_FILE),
                'controlbar': 'bottom',
                'width': $(this).attr(CONFIG_ATTR_WIDTH),
                'height': $(this).attr(CONFIG_ATTR_HEIGHT),
                'image': CONFIG_URL_MEDIA + 'images/' + $(this).attr(CONFIG_ATTR_IMAGE)
            //'skin' : '{static_frontend()}js/jwplayer/skins/grungetape/grungetape.zip'
            });
        })
    }
    
    if(dvd_is_exist($(TOOL_FLASH_OBJECT)))
    {
        $(TOOL_FLASH_OBJECT).each(function(){
            var html = "<object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width=\""+ $(this).attr(CONFIG_ATTR_WIDTH) +"\" height=\""+ $(this).attr(CONFIG_ATTR_HEIGHT) +"\">"
            +"<param name='movie' value='"+ $(this).attr(CONFIG_ATTR_DATA) +"' />"
            +"<param name='quality' value='high' />"
            +"<param name='wmode' value='transparent' />"
            +"<param name='swfversion' value='6.0.65.0' />"        		
            +"<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->"       	    
            +"<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->"
            +"<!--[if !IE]>-->"
            +"<object type=\"application/x-shockwave-flash\" data=\""+ $(this).attr(CONFIG_ATTR_DATA) +"\" width=\""+ $(this).attr(CONFIG_ATTR_WIDTH) +"\" height=\""+ $(this).attr(CONFIG_ATTR_HEIGHT) +"\">"
            +"<!--<![endif]-->"
            +" <param name=\"quality\" value=\"high\" />"
            +"<param name=\"wmode\" value=\"transparent\" />"        	      
            +"<param name=\"swfversion\" value=\"6.0.65.0\" />"        	      
            +" <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->"
            +"<div>"
            +"<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>"
            +"<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\""+ $(this).attr(CONFIG_ATTR_IMAGE) +"\" alt=\"Get Adobe Flash player\" width=\"112\" height=\"33\" /></a></p>"
            +"</object></object>";
        
            $(this).html(html);
        })
    }

})
