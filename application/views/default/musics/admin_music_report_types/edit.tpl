
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit music report types')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMusics').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormEditMusics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{$data_edit->slug}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$data_edit->weight}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('parent_id')}</td>
                    <td class="left">
                        <select name="parent_id">                            
                            <option value="0">{lang('Select category')}</option>
                            {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($parent_ids, $category_html, 0, $indent_symbol, array($data_edit->parent_id))}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword">{$data_edit->meta_keyword}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{$data_edit->meta_description}</textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
