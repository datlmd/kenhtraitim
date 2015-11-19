jQuery(document).ready(function($) {
    // player
    if ($('#JsIdMediaPlayer').length > 0)
    {        
        jwplayer("JsIdMediaPlayer").setup({ 
            flashplayer: static_url + "static/" + template + "/js/jwplayer/player.swf" 
        });     
    }
    
    $('#JsMusicComment').livequery('keypress', function (e) {
        if (e.keyCode == 13)
        {
            $('#JsFormMusicComment').submit();
        }
    });
})