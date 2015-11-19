{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Games
 * 
 * @package PenguinFW
 * @subpackage games
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin games')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddGames').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddGames">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('piattos_code')}</td>
                    <td class="left"><input type="text" name="piattos_code" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map')}</td>
                    <td class="left"><input type="text" name="map" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('level')}</td>
                    <td class="left"><input type="text" name="level" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('result')}</td>
                    <td class="left"><input type="text" name="result" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('points')}</td>
                    <td class="left"><input type="text" name="points" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time')}</td>
                    <td class="left"><input type="text" name="time" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('piattos_pack')}</td>
                    <td class="left"><input type="text" name="piattos_pack" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('lucky_stars')}</td>
                    <td class="left"><input type="text" name="lucky_stars" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('piattos_character')}</td>
                    <td class="left"><input type="text" name="piattos_character" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('lucky_prize')}</td>
                    <td class="left"><input type="text" name="lucky_prize" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('car')}</td>
                    <td class="left"><input type="text" name="car" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('start_time')}</td>
                    <td class="left"><input type="text" name="start_time" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('end_time')}</td>
                    <td class="left"><input type="text" name="end_time" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
