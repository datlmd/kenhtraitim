
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Pages
 * 
 * @package PenguinFW
 * @subpackage pages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin pages')}</h1>

    <div class=buttons>
        <a href="{base_url()}pages/admin_pages/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
        <a href="{base_url()}pages/admin_pages/preview/{$data_view->id}" class="button" rel="shadowbox"><span>{lang('Preview')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{lang('Link')}</td>
                <td class="left">{base_url('pages/view')}/{$data_view->id}/{$data_view->slug}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('modified')}</td>
                <td class="left">{pg_field_value($data_view->modified, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('title')}</td>
                <td class="left">{pg_field_value($data_view->title, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{pg_field_value($data_view->slug, 'TEXT')}</td>
            </tr>            

            <tr>
                <td class="left head">{get_label('parent_id')}</td>
                <td class="left">{pg_field_value($data_view->parent_id, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('layout')}</td>
                <td class="left">{pg_field_value($data_view->layout, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('is_active')}</td>
                <td class="left">{pg_field_value($data_view->is_active, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_keyword')}</td>
                <td class="left">{pg_field_value($data_view->meta_keyword, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_description')}</td>
                <td class="left">{pg_field_value($data_view->meta_description, 'AREA')}</td>
            </tr>            

        </tbody>
    </table>
</div>
