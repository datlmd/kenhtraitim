
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Users
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin users')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}        
    <form action="" method="post" id="FormEditUsers">
        <input type="hidden" name="user_id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>                
                <tr>
                    <td class="left">{get_label('user_status_id')}</td>
                    <td class="left">
                        <select name="user_status_id">                            
                            {foreach $user_status_ids as $user_status_id}
                                <option value="{$user_status_id.id}" {if $edit_module->user_status_id eq $user_status_id.id}selected{/if}>{lang($user_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_administrator')}</td>
                    <td class="left">
                        <input type="checkbox" value="1" name="is_administrator" {if $edit_module->is_administrator eq 1} checked{/if}/>
                    </td>
                </tr>

                <tr>
	                <td class="left">{get_label('thumbnail_image')}</td>
	                <td class="left">
	                    <input type="hidden" name="thumbnail_image" value="{$edit_module->thumbnail_image}" />
	                    <div id="btnAvatarUpload" class="button-upload" {if $edit_module->thumbnail_image neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
	                    <div class="image-medium-thum" {if $edit_module->thumbnail_image eq ''}style="display:none;"{/if}>
	                    	<a href="{img_url()}media/images/{$edit_module->thumbnail_image}" rel="shadowbox">
	                        	<img src="{base_url()}media/images/{get_image_thumb($edit_module->thumbnail_image, 'small_thumb')}" />
	                        </a>
	                        <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
	                    </div>
	                </td>
	            </tr>

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$edit_module->username}" /></td>
                </tr>                

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="{$edit_module->email}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('passport')}</td>
                    <td class="left"><input type="text" name="passport" value="{$edit_module->passport}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('passport_region_id')}</td>
                    <td class="left">
                        <select name="passport_region_id">
                            <option value=""></option>
                            {foreach $passport_region_ids as $passport_province_id}
                                <option value="{$passport_province_id.id}" {if $edit_module->passport_region_id eq $passport_province_id.id}selected{/if}>{lang($passport_province_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('passport_created')}</td>
                    <td class="left"><input type="text" name="passport_created" class="pgDate" value="{standar_date($edit_module->passport_created, '-', '/', TRUE)}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('full_name')}</td>
                    <td class="left"><input type="text" name="full_name" value="{$edit_module->full_name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('gender_id')}</td>
                    <td class="left">
                        <select name="gender_id">                            
                            {foreach $gender_ids as $gender_id}
                                <option value="{$gender_id.id}" {if $edit_module->gender_id eq $gender_id.id}selected{/if}>{lang($gender_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" class="pgDate" value="{standar_date($edit_module->dob, '-', '/', TRUE)}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('phone')}</td>
                    <td class="left"><input type="text" name="phone" value="{$edit_module->phone}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('address')}</td>
                    <td class="left"><input type="text" name="address" value="{$edit_module->address}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('region_id')}</td>
                    <td class="left">
                        <select name="region_id">
                            <option value=""></option>
                            {foreach $region_ids as $province_id}
                                <option value="{$province_id.id}" {if $edit_module->region_id eq $province_id.id}selected{/if}>{lang($province_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('married_status_id')}</td>
                    <td class="left">
                        <select name="married_status_id">                            
                            {foreach $married_status_ids as $married_status_id}
                                <option value="{$married_status_id.id}" {if $edit_module->married_status_id eq $married_status_id.id}selected{/if}>{lang($married_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('job_id')}</td>
                    <td class="left">
                        <select name="job_id">
                            <option value=""></option>
                            {foreach $job_ids as $job_id}
                                <option value="{$job_id.id}" {if $edit_module->job_id eq $job_id.id}selected{/if}>{lang($job_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                               

                <tr>
                    <td class="left">{get_label('user_type_id')}</td>
                    <td class="left">
                        <select name="user_type_id">                            
                            {foreach $user_type_ids as $user_type_id}
                                <option value="{$user_type_id.id}" {if $edit_module->user_type_id eq $user_type_id.id}selected{/if}>{lang($user_type_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_level_id')}</td>
                    <td class="left">
                        <select name="user_level_id">                            
                            {foreach $user_level_ids as $user_level_id}
                                <option value="{$user_level_id.id}" {if $edit_module->user_level_id eq $user_level_id.id}selected{/if}>{lang($user_level_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_role_id')}</td>
                    <td class="left">
                        <select name="user_role_id">                            
                            {foreach $user_role_ids as $user_role_id}
                                <option value="{$user_role_id.id}" {if $edit_module->user_role_id eq $user_role_id.id}selected{/if}>{lang($user_role_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>               
            
            </tbody>
        </table>
    </form>

</div>
