{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Dashboard Admin
 * 
 * @package PenguinFW
 * @subpackage ...
 * @version 1.0.0
 */
 
*}

<div class="heading">
    <h1>{lang('Dashboard')}</h1>
    
    <div class=buttons>
        <a href="#this" class="button"><span>{lang('Refresh')}</span></a>        
    </div>
</div>
<div class="content">
    <div class="cpanel-left">
        <div class="cpanel">
            {foreach $icons as $icon}
                <div class="icon-wrapper">
                    <div class="icon">
                        <a href="{base_url()}{$icon.link}">
                            <img src="{static_base()}images/admin/{$icon.image}" alt="">
                            <span>{$icon.label}</span>
                        </a>
                    </div>
                </div>
            {/foreach}            
        </div>
    </div>
        
    <div class="cpanel-right">
        <table class="list">
            <thead>
                <tr>
                    <td class="center" colspan="5">Top user login</td>
                </tr>
                
                <tr>
                    <td class="left">{lang('User name')}</td>
                    <td class="left">{lang('Full name')}</td>
                    <td class="left">{lang('Login date')}</td>
                    <td class="left">{lang('ID')}</td>
                    <td class="left">{lang('Role')}</td>
                </tr>
            </thead>
            <tbody>
                {foreach $users as $user}
                    <tr>
                        <td class="left">{$user.username}</td>
                        <td class="left">{$user.full_name}</td>
                        <td class="left">{$user.login_created}</td>
                        <td class="left">{$user.id}</td>
                        <td class="left">{$user.role}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    
    <div class="clr"></div>
</div>