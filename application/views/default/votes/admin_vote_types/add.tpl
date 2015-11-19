
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Votes
 * 
 * @package PenguinFW
 * @subpackage votes
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Vote types')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddVotes').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddVotes">
        <table class="list">
            <tbody>
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('point')}</td>
                    <td class="left"><input type="text" name="point" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_subtract')}</td>
                    <td class="left"><input type="checkbox" name="is_subtract" value="1" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_dislike')}</td>
                    <td class="left"><input type="checkbox" name="is_dislike" value="1" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_multi')}</td>
                    <td class="left"><input type="checkbox" name="is_multi" value="1" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_minutes')}</td>
                    <td class="left"><input type="text" name="time_minutes" value="2" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_second_user')}</td>
                    <td class="left"><input type="text" name="time_second_user" value="30" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_second_browser')}</td>
                    <td class="left"><input type="text" name="time_second_browser" value="3600" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time_second_ip')}</td>
                    <td class="left"><input type="text" name="time_second_ip" value="300" /></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>
