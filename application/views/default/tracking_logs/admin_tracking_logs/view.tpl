{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Tracking_logs
 * 
 * @package PenguinFW
 * @subpackage tracking_logs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin tracking logs')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <div style="width: 100%;height: 500px;overflow: scroll;">
        {$data_view}
    </div>
</div>
