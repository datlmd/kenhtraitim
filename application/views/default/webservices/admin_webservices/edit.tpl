
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Webservices
 * 
 * @package PenguinFW
 * @subpackage webservices
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit webservices')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditWebservices').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    
    
    <form action="" method="post" id="FormEditWebservices">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('public_key')}</td>
                    <td class="left"><input type="text" name="public_key" value="{$data_edit->public_key}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('secret_key')}</td>
                    <td class="left"><input type="text" name="secret_key" value="{$data_edit->secret_key}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('service')}</td>
                    <td class="left"><input type="text" name="service" value="{$data_edit->service}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('allow_ip')}</td>
                    <td class="left"><input type="text" name="allow_ip" value="{$data_edit->allow_ip}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('type')}</td>
                    <td class="left">
                        <select name="type">
                            {if $data_edit->type eq $type_get}
                                <option value="{$type_get}">GET</option>
                                <option value="{$type_post}">POST</option>
                            {else}
                                <option value="{$type_post}">POST</option>
                                <option value="{$type_get}">GET</option>                                
                            {/if}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_public')}</td>
                    <td class="left">
                        <select name="is_public">
                            {if $data_edit->is_public eq 0}
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            {else}
                                <option value="1">Yes</option>
                                <option value="0">No</option>                                
                            {/if}
                        </select>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
