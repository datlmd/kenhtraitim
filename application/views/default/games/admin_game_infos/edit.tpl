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
    <h1>{lang('Edit Admin game infos')}</h1>

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
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map1_total_score')}</td>
                    <td class="left"><input type="text" name="map1_total_score" value="{$data_edit->map1_total_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map1_lv1_score')}</td>
                    <td class="left"><input type="text" name="map1_lv1_score" value="{$data_edit->map1_lv1_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map1_lv2_score')}</td>
                    <td class="left"><input type="text" name="map1_lv2_score" value="{$data_edit->map1_lv2_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map1_top_lv')}</td>
                    <td class="left"><input type="text" name="map1_top_lv" value="{$data_edit->map1_top_lv}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map2_total_score')}</td>
                    <td class="left"><input type="text" name="map2_total_score" value="{$data_edit->map2_total_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map2_lv1_score')}</td>
                    <td class="left"><input type="text" name="map2_lv1_score" value="{$data_edit->map2_lv1_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map2_lv2_score')}</td>
                    <td class="left"><input type="text" name="map2_lv2_score" value="{$data_edit->map2_lv2_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map2_top_lv')}</td>
                    <td class="left"><input type="text" name="map2_top_lv" value="{$data_edit->map2_top_lv}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map3_total_score')}</td>
                    <td class="left"><input type="text" name="map3_total_score" value="{$data_edit->map3_total_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map3_lv1_score')}</td>
                    <td class="left"><input type="text" name="map3_lv1_score" value="{$data_edit->map3_lv1_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map3_lv2_score')}</td>
                    <td class="left"><input type="text" name="map3_lv2_score" value="{$data_edit->map3_lv2_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('map3_top_lv')}</td>
                    <td class="left"><input type="text" name="map3_top_lv" value="{$data_edit->map3_top_lv}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('lucky_prize')}</td>
                    <td class="left"><input type="text" name="lucky_prize" value="{$data_edit->lucky_prize}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('total_score')}</td>
                    <td class="left"><input type="text" name="total_score" value="{$data_edit->total_score}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('ip_create')}</td>
                    <td class="left"><input type="text" name="ip_create" value="{$data_edit->ip_create}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
