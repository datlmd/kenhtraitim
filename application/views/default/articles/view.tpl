{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * View article
 * 
 * @package PenguinFW
 * @subpackage Article
 * @version 1.0.0
 */

*}

<div class="hlSong even">
    <div class="hlBar">
        <div class="left">
            <div class="blockL">
                <div class="inner">
                    <div class="title"><h2>{$article.subject}</h2></div>
                    <div class="lstSong">                                            
                        <div style="padding:10px;color:#333333;">
                            {$article.content}
                            
                            {if $article.is_allow_comment}
                                {include file="./add_comment.tpl" params_comment=$params_comment}
                            {/if}
                            
                            <div id="IdMusicPlayer"></div>
                            {if is_allow($this->session->userdata('user_user_role_id'), 'musics', 'w')}
                                <a href="javascript:AddMusicVote('{$params_vote}')" style="display:inline-block;padding:5px;background:#999999;font-weight:700;">{lang('Vote')}</a>
                            {/if}
                        </div>
                    </div>                    
                </div>                
            </div>            
        </div>
    </div>
</div>
<span id="{$idd_post}" style="display:none;">{$params_post}</span>