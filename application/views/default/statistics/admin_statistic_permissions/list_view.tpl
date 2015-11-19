{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin View table list
 * 
 * @package PenguinFW
 * @subpackage Element
 * @version 1.0.0
 */

*}

<table class="list AdminPermission">
    {if $fields eq false}
        <tbody>
            <tr><td class="left">{lang('No record')}</td></tr>
        </tbody>
    {else}
        <thead>
            <tr>

                {foreach from=$fields key=field item=field_type}
                    {if $field eq 'permission'}
                        <td class="left colRadio">
                            {get_label($field)}
                            
                            <div style="float: right; width: 95px;">
                                
                                 <a class="off_all_btn " href="javascript:void(0)" onClick="turn_all_radio('.rad_off')" class="button"><span>{lang(' Off all ')}</span></a>
 
                                  <a class="on_all_btn" href="javascript:void(0)" onClick="turn_all_radio('.rad_on');" class="button"><span>{lang(' On all ')}</span></a>
 
                               
                            </div>
                        </td>
                    {else}
                        <td class="left">{get_label($field)}</td>
                    {/if}
                {/foreach}

            </tr>
        </thead>

        <tbody>
            {foreach $users as $user}

                <tr>    

                    <td class="left">
                        {$user.username}
                    </td>
                    
                    <td class="left colRadio">
                        <input class="rad_off" type="radio" id="permission{$user.id}_0" value="0" name="permission[{$user.id}]" checked="checked" /> 
                        <label for="permission{$user.id}_0">Off</label> 

                        <input class="rad_on" type="radio" id="permission{$user.id}_1" value="1" name="permission[{$user.id}]" {if $current_permissions[$user.id].permission == 1}checked="checked"{/if} /> 
                        <label for="permission{$user.id}_1">On</label>
                    </td>

                </tr>
            {foreachelse}
                <tr>
                    <td class="left" colspan="10">{lang('No record')}</td>
                </tr>
            {/foreach}   

        </tbody>
    {/if}
</table>

<div style="width: 100%; height: 20px;">
    <div style="width:60% ; margin-top: 7px; float: left;">{$pagination_link}</div>
{if $total_records}<div id="total_records" style="width: 30%; text-align: right ; color:blue; float:right; font-weight: bold; font-size: 19px;" >Total: {$total_records} records</div>{/if}
</div>
