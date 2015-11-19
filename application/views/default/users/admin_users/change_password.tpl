{* Add by hungtd *}
<div class="heading">
    <h1>{lang('Change password')} {$user->username}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditUsers').submit();" class="button"><span>{lang('Change password')}</span></a>
    </div>
</div>

<div class="content">            
    <form action="" method="post" id="FormEditUsers">
        <input type="hidden" name="user_id" value="{$user->id}" />
        <table class="list">
            <tbody>
                <tr{if !$is_owner} class="hide"{/if}>
                    <td class="left">{lang('Old password')}</td>
                    <td class="left">
                        <input type="password" name="old_password" value="" maxlength="32" />
                    </td>
                </tr>                                

                <tr>
                    <td class="left">{lang('New password')}</td>
                    <td class="left">
                        <input type="password" name="new_password" value="" maxlength="32" />
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{lang('Again password')}</td>
                    <td class="left">
                        <input type="password" name="again_password" value="" maxlength="32" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>