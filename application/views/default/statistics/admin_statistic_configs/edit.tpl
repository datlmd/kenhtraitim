{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Statistics
 * 
 * @package PenguinFW
 * @subpackage statistics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin statistic configs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onclick="validate_value()"  class="button" ddiv="frm_edit"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" class="frm_edit" dsubmit="1" method="post" id="FormEditStatistics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
<!--                <tr>
                    <td class="left">{get_label('campaign_id')}</td>
                    <td class="left">
                        <select name="campaign_id">
      
                            {foreach $campaign_ids as $campaign_id}
                                <option value="{$campaign_id.id}" {if $data_edit->campaign_id eq $campaign_id.id}selected{/if}>{lang($campaign_id.name)}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>-->
                
                <tr>
                    <td class="left">{get_label('type')}</td>
                    <td class="left">
                        <select name="type" class="type">
                            <option value="Db" {if $data_edit->type eq 'Db'}selected{/if}>{lang('Local Database')}</option>
                            <option value="Ga" {if $data_edit->type eq 'Ga'}selected{/if}>{lang('Google Analyst')}</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('value')}</td>
                    <td class="left"><textarea class="txt_value dvd_valid_txt_empty" dnull="1" name="value">{$data_edit->value}</textarea> 
                        <a style="position: relative;top: -40px;left: 10px;" href="javascript:void(0)" onclick="test_value($('.type').val() ,$('.txt_value').val(), '/statistics/admin_statistic_configs/test_sql/{$data_edit->campaign_id}')" class="button"><span>Test</span></a>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('kpi')}</td>
                    <td class="left"><input type="text" name="kpi" value="{$data_edit->kpi}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
                        
                        <script type="text/javascript">
                            function validate_value()
                            {
                                var result = test_value($('.type').val() ,$('.txt_value').val(), '/statistics/admin_statistic_configs/test_sql/{$data_edit->campaign_id}')
                                
                                if(result == 1)
                                    $("#FormEditStatistics").submit();
                                }
                    </script>
