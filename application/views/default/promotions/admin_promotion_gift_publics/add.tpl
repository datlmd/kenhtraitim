{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Promotions
 * 
 * @package PenguinFW
 * @subpackage promotions
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin promotion gift publics')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddPromotions').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddPromotions">
        <table class="list">
            <tbody>            
                
                 <tr>
                    <td class="left">{get_label('id_gift')}</td>
                    <td class="left">
                    	<select name="id_gift">                            
                            {foreach $categories as $category}
                                <option value="{$category.id}">{$category.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('total')}</td>
                    <td class="left"><input type="text" name="total" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('public_date')}</td>
                    <td class="left"><input type="text" class="pgDate" name="public_date" value="" />
                    	<input type="text" class="pgTime" name="publish_time" />
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_public')}</td>
                    <td class="left">
                    	<select id="is_hot" name="is_public">
                        	<option value="0">Un Publish</option>
                        	<option value="1">Publish</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
