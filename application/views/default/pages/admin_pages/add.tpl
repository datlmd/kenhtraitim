
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Pages
 * 
 * @package PenguinFW
 * @subpackage pages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add pages')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddPages').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddPages">
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('title')}</td>
                    <td class="left"><input type="text" name="title" value="{set_value('title')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{set_value('slug')}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('page_link')}</td>
                    <td class="left"><input type="text" name="page_link" value="{set_value('page_link')}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('lang_code')}</td>
                    <td class="left">
                        <select name="lang_code">
                            {foreach $languages as $language}
                                <option value="{$language.code}">{$language.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('mapto_id')}</td>
                    <td class="left"><input type="text" name="mapto_id" value="{set_value('mapto_id')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('content')}</td>
                    {*<td class="left"><textarea name="content">{set_value('content')}</textarea></td>*}
                    <td>
                        <div class=textarea>
                            <textarea name="content" class="html_template" id="content">{set_value('content')}</textarea>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('parent_id')}</td>
                    <td class="left">
                        <select name="parent_id">
                            <option value="0"></option>
                            {foreach $parent_ids as $parent_id}
                                <option value="{$parent_id.id}">{lang($parent_id.title)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('layout')}</td>
                    <td class="left"><input type="text" name="layout" value="{set_value('layout', 'default')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_active')}</td>
                    <td class="left"><input type="checkbox" name="is_active" value="1" {set_checkbox('is_active', 1)} /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword">{set_value('meta_keyword')}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{set_value('meta_description')}</textarea></td>
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