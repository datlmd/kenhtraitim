{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Statistics
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin statistic campaigns')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddStatistics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormAddStatistics">
        <table class="list">
            <tbody>            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{set_value('name')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">                        
                        <input type="hidden" name="avatar" value="{set_value('avatar')}" />
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>                        
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('start_date')}</td>
                    <td class="left"><input type="text"  class="pgDate" name="start_date" value="{set_value('start_date')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('end_date')}</td>
                    <td class="left"><input type="text" class="pgDate" name="end_date" value="{set_value('end_date')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description">{set_value('description')}</textarea>                
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('db server')}</td>
                    <td class="left"><input type="text" name="db_server" value="{set_value('db_server')}" /></td>

                </tr>

                </tr>

                <tr>
                    <td class="left">{get_label('db name')}</td>
                    <td class="left"><input type="text" name="db_name" value="{set_value('db_name')}" /></td>

                </tr>

                <tr>
                    <td class="left">{get_label('db username')}</td>
                    <td class="left"><input type="text" name="db_username" value="{set_value('db_username')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('db password')}</td>
                    <td class="left"><input type="password" name="db_password" value="{set_value('db_password')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ga id')}</td>
                    <td class="left"><input type="text" name="ga_id" value="{set_value('ga_id')}" /></td>

                </tr>

                <tr>
                    <td class="left">{get_label('ga_username')}</td>
                    <td class="left"><input type="text" name="ga_username" value="{set_value('ga_username')}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ga_password')}</td>
                    <td class="left"><input type="password" name="ga_password" value="{set_value('ga_password')}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('saler (account)')}</td>
                    <td class="left"><input type="text" name="saler" value="{set_value('saler')}" /></td>
                </tr>

            </tbody>
        </table>
    </form>

</div>
