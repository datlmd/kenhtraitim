
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Pages
 * 
 * @package PenguinFW
 * @subpackage pages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit pages')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditPages').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    
    
    <form action="" method="post" id="FormEditPages">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('title')}</td>
                    <td class="left"><input type="text" name="title" value="{set_value('title',$data_edit->title)}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{set_value('slug',$data_edit->slug)}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('page_link')}</td>
                    <td class="left"><input type="text" name="page_link" value="{set_value('page_link',$data_edit->page_link)}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('lang_code')}</td>
                    <td class="left">
                        <select name="lang_code">
                            {foreach $languages as $language}
                                <option value="{$language.code}"{if $data_edit->lang_code eq $language.code} selected{/if}>{$language.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('mapto_id')}</td>
                    <td class="left"><input type="text" name="mapto_id" value="{set_value('mapto_id',$data_edit->mapto_id)}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('content')}</td>
                    {*<td class="left"><textarea name="content">{set_value('content',$data_edit->content)}</textarea></td>*}
                    <td>
                        <div class=textarea>
                            <textarea name="content" class="html_template" id="content">{set_value('content',$data_edit->content)}</textarea>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('parent_id')}</td>
                    <td class="left">
                        <select name="parent_id">
                            <option value="0"></option>
                            {foreach $parent_ids as $parent_id}
                                <option value="{$parent_id.id}" {if $data_edit->parent_id eq $parent_id.id}selected{/if}>{lang($parent_id.title)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('layout')}</td>
                    <td class="left"><input type="text" name="layout" value="{set_value('layout',$data_edit->layout)}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_active')}</td>
                    <td class="left"><input type="checkbox" name="is_active" value="{$data_edit->is_active}" {set_checkbox('is_active', $data_edit->is_active, TRUE)}/></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword">{set_value('meta_keyword',$data_edit->meta_keyword)}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{set_value('meta_description',$data_edit->meta_description)}</textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>

<link rel="stylesheet" href='{base_url()}static/default/js/CodeMirror/lib/codemirror.css' />
<script src='{base_url()}static/default/js/CodeMirror/lib/codemirror.js' type="text/javascript"></script>
<link rel="stylesheet" href='{base_url()}static/default/js/CodeMirror/theme/cobalt.css' />
<script src='{base_url()}static/default/js/CodeMirror/mode/xml/xml.js' type="text/javascript"></script>
<script src="{base_url()}static/default/js/CodeMirror/addon/edit/closetag.js"></script>
<script src="{base_url()}static/default/js/CodeMirror/addon/display/fullscreen.js"></script>
<script type="text/javascript">
    var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
        lineNumbers: true,
        mode: 'text/html',
        autoCloseTags: true,
        theme: 'cobalt'
    });
</script>