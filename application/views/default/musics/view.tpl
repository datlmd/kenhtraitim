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
                    <div class="title"><h2>{$music->name}</h2></div>
                    <div class="lstSong">                                                
                        <div style="padding:10px;color:#333333;">
                            <div id="IdMusicPlayer"></div>
                            {if is_allow($this->session->userdata('user_user_role_id'), 'musics', 'w')}
                                <a href="javascript:AddVote('{$params_vote}')" style="display:inline-block;padding:5px;background:#999999;font-weight:700;">{lang('Vote')}</a>
                            {/if}
                            
                            <div id="JsMusicCommentContent"></div>
                            <form id="JsFormMusicComment" action="javascript:AddComment('JsMusicComment', 'JsMusicCommentParams', 'JsMusicCommentContent');">
                                <input type="hidden" value="{$params_comment}" name="JsMusicCommentParams" id="JsMusicCommentParams" />
                                <textarea name="comment-music-text" id="JsMusicComment"></textarea>
                            </form>
                        </div>
                    </div>                    
                </div>                
            </div>            
        </div>
    </div>
</div>
<span id="{$idd_post}" style="display:none;">{$params_post}</span>

<script tyle="text/javascript">
    jQuery(document).ready(function($) {
        $f('IdMusicPlayer', static_url + 'static/' + template + '/js/flowplayer/flowplayer-3.2.7.swf', {           
            clip: { 
               url: mp3_url + 'media/{$music_type}/musics/{$music->file}',
               onCuepoint: [
                   [{$time_on_view}],
                   function () {
                        addListenMusic('{$idd_post}');
                   }
               ]
            },
            plugins: {
                controls: {
                    playlist: false,
                    autoHide: false
                }                
            }
        });                
        
    });
</script>