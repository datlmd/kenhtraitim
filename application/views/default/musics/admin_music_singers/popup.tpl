
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW 
 * 
 * @package PenguinFW
 * @subpackage Musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Music singers manager')}</h1>

    <div class=buttons>
        <a href="{base_url('musics/admin_music_singers/add')}/1?insert_id={$smarty.get.insert_id}&insert_name={$smarty.get.insert_name}" class="button"><span>{lang('Add')}</span></a>        
    </div>
</div>

<div class="content">
    <form action="" method="get" id="MusicsSearch">
        <table class="filter">
            <tbody>
                <tr>
                    
                    <td>
                        <label>{lang('Name')}</label>
                        <input type="text" name="name" value="{$smarty.get.name}" />
                    </td>
				
                    <td><a onclick="$('#MusicsSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <table class="list">
        <thead>
            <tr>
                <td class="left">{lang('Name')}</td>                
            </tr>
        </thead>
        
        <tbody>
            {foreach $list_views as $list_view}
                <tr>
                    <td class="left">
                        <a href="#this" onClick="getPopupData('JsPopup_singer_id', '{$list_view.id}', 'JsPopup_singer_name', '{$list_view.name}')">
                            {$list_view.name}
                        </a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

</div>
