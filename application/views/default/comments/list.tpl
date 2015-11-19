{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Add Comment
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 */

*}

<div class="cmt_tit js_comment_list">Bình luận ({$total_comments})</div>
<div class="scroll-pane" style="width:415px;height:380px">
{foreach $comments as $comment}
    <div class="cmt">
        <div class="avatar" style="margin-left:0px;"><img width="80" height="80" src="http://1.s50.avatar.zdn.vn/avatar_files/4/5/2/6/{$comment.username}_50_50.jpg" alt="" /></div>
        <div class="cmt_block">
            <div class="cmt_block_top">
                {$comment.comment}
            </div>
            <div class="cmt_block_bottom">
                Đăng bởi &nbsp;  <strong>{$comment.username}</strong> &nbsp; | &nbsp; {date('d/m/Y',strtotime($comment.created))}
            </div>
        </div>
    </div>
{/foreach}
</div>
<div>{$pages_link}</div>