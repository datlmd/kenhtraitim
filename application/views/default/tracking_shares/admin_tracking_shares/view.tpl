{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Tracking_shares
 * 
 * @package PenguinFW
 * @subpackage tracking_shares
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin tracking shares')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('share_name')}</td>
                <td class="left">{pg_field_value($data_view->share_name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('share_link_on_page')}</td>
                <td class="left">{pg_field_value($data_view->share_link_on_page, 'TEXT')}</td>
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
                <td class="left head">{get_label('ip')}</td>
                <td class="left">{pg_field_value($data_view->ip, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
