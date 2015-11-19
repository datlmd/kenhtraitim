
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * ADD Category
 * 
 * @package PenguinFW
 * @subpackage photos
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin category')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddUsers">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('category_status_id')}</td>
                    <td class="left">
                        <select name="category_status_id">                            
                            {foreach $category_status_ids as $category_status_id}
                                <option value="{$category_status_id.id}">{lang($category_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                                

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea rows="5" cols="33" name="description"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('parent_id')}</td>
                    <td class="left">
                    	<select name="parent_id">
                    	   <option value="0">{lang('Select parent')}</option>
                           {$category_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                           {$indent_symbol = '-&nbsp;'}
                           {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($smarty.post.parent_id))}
                        </select>
					</td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="0" /></td>
                </tr>
                         
            </tbody>
        </table>
    </form>

</div>
