
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST VIEW TRANSLATE
 * 
 * @package PenguinFW
 * @subpackage Languages
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Translate languages')}</h1>

    <div class=buttons>
        <a href="#this" class="button" onclick="window.open('{base_url('languages/admin_translations/search')}', '', 'width=1000,height=500');"><span>{lang('Search')}</span></a>
        <a href="{base_url('languages/admin_translations/add')}/{$module_id}/{$lang_id}" class="button"><span>{lang('Add')}</span></a>        
        <a href="javascript:void(0);" class="button" onClick="$('#JsTranslateTranslation').submit();"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {if $translations eq FALSE}
        {lang('Not record')} 
        {if $language->id neq 1}
            [ <a href="{base_url('languages/admin_translations/copy')}/{$module_id}/{$lang_id}">{lang('Add key from default')}</a> ]
        {/if}
    {else}
        <form action="" method="get" id="LanguagesSearch">
            <table class="filter">
                <tbody>
                    <tr>

                        <td>
                            <label>{lang('Keyword')}</label>
                            <input type="text" name="q" value="{$smarty.get.q}" />
                        </td>

                        <td><a onclick="$('#LanguagesSearch').submit();" href="javascript:void(0);" class="button"><span>{lang('Filter')}</span></a></td>
                    </tr>
                </tbody>
            </table>
        </form>
        
        <form action="" id="JsTranslateTranslation" method="post">
            <table class="list">
                <thead>
                    <tr>
                        <td class="left">{lang('Key')}</td>
                        <td class="left">{lang('Translate value')}</td>
                        <td class="left">{lang('Action')}</td>
                    </tr>
                </thead>
                
                <tbody>
                    {foreach $translations as $translation}
                        <tr>
                            <td class="left">{$translation.key}</td>
                            <td class="left"><textarea name="translate[{$translation.id}]">{$translation.value}</textarea></td>
                            <td class="left"><a href="{base_url()}languages/admin_translations/delete/{$translation.id}">{lang('Delete')}</a></td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </form>
    {/if}    

</div>
