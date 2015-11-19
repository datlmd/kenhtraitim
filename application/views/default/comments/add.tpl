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

<div class="MainBlock">        
    <form action="" method="post">
        <input type="hidden" name="resource" value="comments" />
        <input type="hidden" name="record_id" value="1" />
        <input type="hidden" name="redirect" value="comments/add" />
        <table>
            <tbody>
                <tr>
                    <td>{lang('Comment')}</td>
                    <td><textarea name="comment"></textarea></td>                    
                </tr>
                
                <tr>
                    <td></td>
                    <td><input type="submit" value="{lang('Comment')}" /></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>