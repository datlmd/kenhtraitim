{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Promotions
 * 
 * @package PenguinFW
 * @subpackage promotions
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin promotion gift publics')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditPromotions').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditPromotions">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('id_gift')}</td>
                    <td class="left">
                    	{$id_g = $data_edit->id_gift}  
                    	<select name="id_gift">
                    		                          
                            {foreach $categories as $category}
                                <option value="{$category.id}" {if $category.id == $id_g}selected{/if}>{$category.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('total')}</td>
                    <td class="left"><input type="text" name="total" value="{$data_edit->total}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('public_date')}</td>
                    <td class="left"><input type="text" class="pgDate" name="public_date" value="{$data_edit->public_date|date_format:"%d-%m-%Y"}" />
                    	<input type="text" class="pgTime" name="publish_time" value="{$data_edit->public_date|date_format:"H:i"}" />
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_public')}</td>
                    <td class="left">
                    	<select id="is_hot" name="is_public">
                        	<option value="0" {if $data_edit->is_public==0}selected{/if}>Un Publish</option>
                        	<option value="1" {if $data_edit->is_public==1}selected{/if}>Publish</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
