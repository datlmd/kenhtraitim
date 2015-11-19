{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Admin tạo thêm 1 menu
 * 
 * @package PenguinFW
 * @subpackage Menu
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add')} {lang('Menu')}</h1>
    
    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMenu').submit();" class="button"><span>{lang('Save')}</span></a>        
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    <form action="{base_url('menus/admin_menus/add')}" method="post" id="FormAddMenu">
        <table class="form">
            <tbody>
                <tr>
                    <td><span class="required">*</span> {lang('Name')}</td>
                    <td><input type="text" name="name" value="" maxlength="200" /></td>
                </tr>                        

                <tr>
                    <td><span class="required">*</span> {lang('Link')}</td>
                    <td><input type="text" name="link" value="" maxlength="200" /></td>
                </tr>               

                <tr>
                    <td>{lang('Parent')}</td>
                    <td>
                        <select name="parent_id">
                            <option value=''></option>
                            {foreach $parent_menus as $parent_menu}
                                <option value={$parent_menu.id}>{$parent_menu.name}</option>    
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>{lang('Weight')}</td>
                    <td><input type="text" name="weight" value="0" /></td>
                </tr>
            </tbody>
        </table>
    </form>    
</div>