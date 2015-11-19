{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View music
 * 
 * @package PenguinFW
 * @subpackage Music
 * @version 1.0.0
 */

*}

<div class="hlSong even">
    <div class="hlBar">
        <div class="left">
            <div class="blockL">
                <div class="inner">
                    <div class="title"><h2>{$album->name}</h2></div>
                    <div class="lstSong">                                                
                        <div style="padding:10px;color:#333333;">
                            <div class="player" id="IdMusicPlayer"></div>
                            <div class="IdMusicPlayerPlaylist">
                                {literal}
                                    <a href="${url}" style="display:block;color:#333333;">${title}</a>
                                {/literal}
                            </div>
                        </div>
                    </div>                    
                </div>                
            </div>            
        </div>
    </div>
</div>
<span id="{$idd_post}" style="display:none;">{$token_post}</span>

<script tyle="text/javascript">
    jQuery(document).ready(function($) {
        $f('IdMusicPlayer', static_url + 'static/' + template + '/js/flowplayer/flowplayer-3.2.7.swf', {           
            playlist: [                
                {foreach $musics as $music}
                    {if $music.type_id eq $mp3_id}
                        {
                            url: '{mp3_url()}media/musics/musics/{$music.file}',
                            title: '{$music.name}',
                            onCuepoint: [
                                [getTimeOnView('{$music.length}')], function () {
                                    addListenAlbum('{$music.id}' , '{$idd_post}');
                                }
                            ]

                        }{if !$music@last},{/if}
                    {/if}
                        
                    {if $music.type_id eq $video_id}
                        {
                            url: '{video_url()}media/videos/musics/{$music.file}',
                            title: '{$music.name}',
                            onCuepoint: [
                                [getTimeOnView('{$music.length}')], function () {
                                    addListenAlbum('{$music.id}' , '{$idd_post}');
                                }
                            ]

                        }{if !$music@last},{/if}
                    {/if}
                {/foreach}                
            ],
            plugins: {
                controls: {
                    playlist: true,
                    autoHide: false
                }
            }
        }).playlist(".IdMusicPlayerPlaylist",  {	            
            loop: true            
        });                
        
    });
</script>