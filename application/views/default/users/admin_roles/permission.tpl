{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin Permission
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Permission')} {lang('Role')}: {$user_role->name}</h1>
    
    <div class=buttons>        
        <a href="javascript:void(0)" onClick="$('#FormPermissionRole').submit();" class="button"><span>{lang('Update')}</span></a>
    </div>
</div>
<div class="content">
    <form action="{base_url('users/admin_roles/permission')}" id="FormPermissionRole" method="post">
        <input type="hidden" name="role_id" value="{$user_role->id}" />
        <table class="list">            
            <thead>
                <tr>
                    <td class="left">{lang('Module')}</td>
                    <td class="left">                        
                        <table class="list" id="nav">
                            <thead>
                                <tr>
                                    <td class="left" width="200px">{lang('Module resource')}</td>
                                    <td class="left" width="100px">Read</td>
                                    <td class="left" width="100px">Write</td>
                                    <td class="left" width="100px">Modify</td>
                                    <td class="left" width="100px">Publish</td>
                                    <td class="left" width="100px">Delete</td>
                                    <td class="left">Trash</td>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>                                
            </thead>

            <tbody>                    
                {foreach $resource_permissions as $resource_permission}
                    <tr>
                        <td class="left">{$resource_permission.module}</td>
                        <td class="left">
                            <table class="list AdminPermission">
                                <tbody>
                                    {foreach $resource_permission.resources as $resource}
                                        <tr>
                                            <td class="left" width="200px">{$resource.name}</td>
                                            <td class="left colRadio" width="100px">                                                
                                                <input type="radio" id="read{$resource.id}0" value="0" name="read[{$resource.id}]" checked="checked" /> 
                                                <label for="read{$resource.id}0">Off</label>
                                                
                                                <input type="radio" id="read{$resource.id}1" value="1" name="read[{$resource.id}]" {if $current_resource_permissions[$resource.id].read eq 1}checked="checked"{/if} /> 
                                                <label for="read{$resource.id}1">On</label>
                                            </td>
                                            <td class="left colRadio" width="100px">
                                                <input type="radio" id="write{$resource.id}0" value="0" name="write[{$resource.id}]" checked="checked" /> 
                                                <label for="write{$resource.id}0">Off</label>
                                                
                                                <input type="radio" id="write{$resource.id}1" value="1" name="write[{$resource.id}]" {if $current_resource_permissions[$resource.id].write eq 1}checked="checked"{/if} /> 
                                                <label for="write{$resource.id}1">On</label>
                                            </td>
                                            <td class="left colRadio" width="100px">
                                                <input type="radio" id="modify{$resource.id}0" value="0" name="modify[{$resource.id}]" checked="checked" /> 
                                                <label for="modify{$resource.id}0">Off</label>
                                                
                                                <input type="radio" id="modify{$resource.id}1" value="1" name="modify[{$resource.id}]" {if $current_resource_permissions[$resource.id].modify eq 1}checked="checked"{/if} /> 
                                                <label for="modify{$resource.id}1">On</label>
                                            </td>
                                            <td class="left colRadio" width="100px">
                                                <input type="radio" id="publish{$resource.id}0" value="0" name="publish[{$resource.id}]" checked="checked" /> 
                                                <label for="publish{$resource.id}0">Off</label>
                                                
                                                <input type="radio" id="publish{$resource.id}1" value="1" name="publish[{$resource.id}]" {if $current_resource_permissions[$resource.id].publish eq 1}checked="checked"{/if} /> 
                                                <label for="publish{$resource.id}1">On</label>
                                            </td>
                                            <td class="left colRadio" width="100px">
                                                <input type="radio" id="delete{$resource.id}0" value="0" name="delete[{$resource.id}]" checked="checked" /> 
                                                <label for="delete{$resource.id}0">Off</label>
                                                
                                                <input type="radio" id="delete{$resource.id}1" value="1" name="delete[{$resource.id}]" {if $current_resource_permissions[$resource.id].delete eq 1}checked="checked"{/if} /> 
                                                <label for="delete{$resource.id}1">On</label>
                                            </td>
                                            <td class="left colRadio">
                                                <input type="radio" id="trash{$resource.id}0" value="0" name="trash[{$resource.id}]" checked="checked" /> 
                                                <label for="trash{$resource.id}0">Off</label>
                                                
                                                <input type="radio" id="trash{$resource.id}1" value="1" name="trash[{$resource.id}]" {if $current_resource_permissions[$resource.id].trash eq 1}checked="checked"{/if} /> 
                                                <label for="trash{$resource.id}1">On</label>
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                {/foreach}
            </tbody>            
        </table>
    </form>    
</div>