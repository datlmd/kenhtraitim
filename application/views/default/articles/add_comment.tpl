{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * Add Comment
 * 
 * @package PenguinFW
 * @subpackage Comment
 * @version 1.0.0
 */

*}


<div class="MainBlock">        
    <form id="JsAddCommentForm" action="" method="post">
        <input type="hidden" name="params_comment" id="JsParamsComment" value="{$params_comment}" />
        <table>
            <tbody>
                <tr>
                    <td>{lang('Comment')}</td>
                    <td><textarea name="comment" id="JsCommentContent"></textarea></td>                    
                </tr>
                
                <tr>
                    <td></td>
                    <td><input type="submit" value="{lang('Comment')}" /></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>



<script type="text/javascript">
$(document).ready(function() {
    $('#JsAddCommentForm').submit(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        
        $.post(base_url + "comments/add_comment", 
                {
                    cparams: $('#JsParamsComment').val(),
                    comment_content: $('#JsCommentContent').val()
                },
                function (json) {
                	var data = $.parseJSON(json);
                	jAlert(data.status, data.message, JsLang[data.status.toUpperCase()]);
                	
                	$('#JsCommentContent').val('');
                }
            );
        
        return false;
    });
});
</script>