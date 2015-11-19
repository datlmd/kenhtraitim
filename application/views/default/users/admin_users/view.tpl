{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin View User Info
 * 
 * @package PenguinFW
 * @subpackage User
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('User info')} {$user->username}</h1>
    
    <div class=buttons>                
        <a href="{base_url()}users/admin_users/edit/{$user->id}" class="button"><span>{lang('Edit')}</span></a>
        <a href="{base_url()}users/admin_users/change_password/{$user->id}" class="button"><span>{lang('Change password')}</span></a>
    </div>
</div>
<div class="content">
    <table class="list">
        <tbody>
            <tr>
                <td class="left head">{get_label('image_name')}</td>
                <td class="left">
                    <div class="image-medium-thum">
                        <a href="{img_url()}media/images/{$user->thumbnail_image}" rel="shadowbox">
                            <img src="{img_url()}media/images/{get_image_thumb($user->thumbnail_image, 'small_thumb')}" />
                            {$user->thumbnail_image}
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left head">{lang('Username')}</td>
                <td class="left">{$user->username}</td>
            </tr>            
            <tr>
                <td class="left head">{lang('Full name')}</td>
                <td class="left">{$user->full_name}</td>
            </tr>            
            <tr>
                <td class="left head">{lang('Passport')}</td>
                <td class="left">{$user->passport}</td>
            </tr>
            <tr>
                <td class="left head">{lang('Phone')}</td>
                <td class="left">{$user->phone}</td>
            </tr>
            <tr>
                <td class="left head">{lang('Email')}</td>
                <td class="left">{$user->email}</td>
            </tr>
            <tr>
                <td class="left head">{lang('Gender')}</td>
                <td class="left">{$user->gender}</td>
            </tr>
            <tr>
                <td class="left head">{lang('DOB')}</td>
                <td class="left">{pg_field_value($user->dob, 'DATE')}</td>
            </tr>
            <tr>
                <td class="left head">{lang('Address')}</td>
                <td class="left">{$user->address}</td>
            </tr>
            <tr>
                <td class="left head">{lang('Join date')}</td>
                <td class="left">{pg_field_value($user->created, 'DATETIME')}</td>
            </tr>
            <tr>
                <td class="left head">{lang('IP join')}</td>
                <td class="left">{$user->register_ip}</td>                
            </tr>
            <tr>
                <td class="left head">{lang('Role')}</td>
                <td class="left">{$user->role}</td>                
            </tr>
            <tr>
                <td class="left head">{lang('Level')}</td>
                <td class="left">{$user->level}</td>                
            </tr>
            <tr>
                <td class="left head">{lang('User type')}</td>
                <td class="left">{$user->user_type}</td>                
            </tr>
        </tbody>
    </table>
</div>