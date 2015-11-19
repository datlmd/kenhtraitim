
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW FILE LANG
 * 
 * @package PenguinFW
 * @subpackage Languages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Admin translation manager')}</h1>

    <div class=buttons>
        <a href="#this" class="button" onclick="window.open('{base_url('languages/admin_translations/search')}', '', 'width=1000,height=500');"><span>{lang('Search')}</span></a>
    </div>
</div>

<div class="content">
    
    <table class="list">
        <thead>
            <tr>                
                <td class="left">{lang('Module')}</td>
                <td class="left">{lang('Action')}</td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td class="left">generate</td>
                <td class="left"><a href="{base_url('languages/admin_translations/translate/-1')}/{$lang_id}">{lang('Edit')}</a></td>
            </tr>
            {foreach $modules as $module}
                <tr>                    
                    <td class="left">{$module.name}</td>
                    <td class="left"><a href="{base_url('languages/admin_translations/translate/')}/{$module.id}/{$lang_id}">{lang('Edit')}</a></td>
                </tr>
            {/foreach}
        </tbody>
    </table>

</div>
