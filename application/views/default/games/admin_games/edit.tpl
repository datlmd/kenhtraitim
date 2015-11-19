{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Games
 * 
 * @package PenguinFW
 * @subpackage games
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin games')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditGames').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditGames">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('piattos_code')}</td>
                    <td class="left"><input type="text" name="piattos_code" value="{$data_edit->piattos_code}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map')}</td>
                    <td class="left"><input type="text" name="map" value="{$data_edit->map}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('level')}</td>
                    <td class="left"><input type="text" name="level" value="{$data_edit->level}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('result')}</td>
                    <td class="left"><input type="text" name="result" value="{$data_edit->result}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('points')}</td>
                    <td class="left"><input type="text" name="points" value="{$data_edit->points}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time')}</td>
                    <td class="left"><input type="text" name="time" value="{$data_edit->time}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('piattos_pack')}</td>
                    <td class="left"><input type="text" name="piattos_pack" value="{$data_edit->piattos_pack}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('lucky_stars')}</td>
                    <td class="left"><input type="text" name="lucky_stars" value="{$data_edit->lucky_stars}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('piattos_character')}</td>
                    <td class="left"><input type="text" name="piattos_character" value="{$data_edit->piattos_character}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('lucky_prize')}</td>
                    <td class="left"><input type="text" name="lucky_prize" value="{$data_edit->lucky_prize}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('car')}</td>
                    <td class="left"><input type="text" name="car" value="{$data_edit->car}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('start_time')}</td>
                    <td class="left"><input type="text" name="start_time" value="{$data_edit->start_time}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('end_time')}</td>
                    <td class="left"><input type="text" name="end_time" value="{$data_edit->end_time}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip')}</td>
                    <td class="left"><input type="text" name="ip" value="{$data_edit->ip}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
