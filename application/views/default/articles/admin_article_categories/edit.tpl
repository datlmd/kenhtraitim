
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * EDIT Category
 * 
 * @package PenguinFW
 * @subpackage articles
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin cateogry')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditUsers">
        <table class="list">
            <tbody>            
                <tr>
	                <td class="left head">{get_label('category_status_id')}</td>
	                <td class="left">
	                   <select name="category_status_id">                            
                            {foreach $category_status_ids as $category_status_id}
                                <option value="{$category_status_id.id}" {if $category_status_id.id == $edit_module.category_status_id}selected{/if}>{lang($category_status_id.name)}</option>
                            {/foreach}
                        </select></td>
	            </tr>            
	            <tr>
	                <td class="left head"><span class="required">*</span> {get_label('name')}</td>
	                <td class="left"><input type="text" name="name" value="{$edit_module.name}" /></td>
	            </tr>            
	            <tr>
	                <td class="left head">{get_label('description')}</td>
	                <td class="left"><textarea rows="5" cols="33" name="description">{$edit_module.description}</textarea></td>
	            </tr>
	            <tr>
	                <td class="left head">{get_label('slug')}</td>
	                <td class="left"><input type="text" name="slug" value="{$edit_module.slug}" /></td>
	            </tr>
	            <tr>
	                <td class="left head">{get_label('parent_id')}</td>
	                <td class="left">
	                   <select name="parent_id">
                           <option value="0">{lang('Select parent')}</option>
                           {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                           {$indent_symbol = '-&nbsp;'}
                           {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, array($edit_module.parent_id))}
                        </select>
                    </td>
	            </tr>
	            <tr>
	                <td class="left head">{get_label('article_counter')}</td>
	                <td class="left"><input type="text" name="article_counter" value="{$edit_module.article_counter}" /></td>
	            </tr>
	            <tr>
	                <td class="left head">{get_label('weight')}</td>
	                <td class="left"><input type="text" name="weight" value="{$edit_module.weight}" /></td>
	            </tr>
	            
            </tbody>
        </table>
    </form>

</div>
