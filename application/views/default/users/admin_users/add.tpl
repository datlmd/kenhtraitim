
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Users
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin users')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}        
    <form action="" method="post" id="FormAddUsers">
        <table class="list">
            <tbody>                
                <tr>
                    <td class="left">{get_label('user_status_id')}</td>
                    <td class="left">
                        <select name="user_status_id">                            
                            {foreach $user_status_ids as $user_status_id}
                                <option value="{$user_status_id.id}">{lang($user_status_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_administrator')}</td>
                    <td class="left">
                        <input type="checkbox" name="is_administrator" value="1" {if $edit_module->is_administrator eq 1} checked{/if}/>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('thumbnail_image')}</td>
                    <td class="left">
                        <input type="hidden" name="thumbnail_image" value="" />
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>
                    </td>
                </tr>

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><span class="required">*</span> {get_label('password')}</td>
                    <td class="left"><input type="password" name="password" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('passport')}</td>
                    <td class="left"><input type="text" name="passport" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('passport_region_id')}</td>
                    <td class="left">
                        <select name="passport_region_id">
                            <option value=""></option>
                            {foreach $passport_region_ids as $passport_region_id}
                                <option value="{$passport_region_id.id}">{$passport_region_id.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('passport_created')}</td>
                    <td class="left"><input type="text" name="passport_created" class="pgDate" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('full_name')}</td>
                    <td class="left"><input type="text" name="full_name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('gender_id')}</td>
                    <td class="left">
                        <select name="gender_id">                            
                            {foreach $gender_ids as $gender_id}
                                <option value="{$gender_id.id}">{lang($gender_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" class="pgDate" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('phone')}</td>
                    <td class="left"><input type="text" name="phone" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('address')}</td>
                    <td class="left"><input type="text" name="address" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('region_id')}</td>
                    <td class="left">
                        <select name="region_id">
                            <option value=""></option>
                            {foreach $region_ids as $region_id}
                                <option value="{$region_id.id}">{lang($region_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('married_status_id')}</td>
                    <td class="left">
                        <select name="married_status_id">                            
                            {foreach $married_status_ids as $married_status_id}
                                <option value="{$married_status_id.id}">{lang($married_status_id.name)}</option>
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
                                <option value="{$job_id.id}">{lang($job_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                              

                <tr>
                    <td class="left">{get_label('user_type_id')}</td>
                    <td class="left">
                        <select name="user_type_id">                            
                            {foreach $user_type_ids as $user_type_id}
                                <option value="{$user_type_id.id}">{lang($user_type_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_level_id')}</td>
                    <td class="left">
                        <select name="user_level_id">                            
                            {foreach $user_level_ids as $user_level_id}
                                <option value="{$user_level_id.id}">{lang($user_level_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('user_role_id')}</td>
                    <td class="left">
                        <select name="user_role_id">                            
                            {foreach $user_role_ids as $user_role_id}
                                <option value="{$user_role_id.id}">{lang($user_role_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>                            
            </tbody>
        </table>
    </form>

</div>
