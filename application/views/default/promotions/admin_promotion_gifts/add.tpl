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
    <h1>{lang('Add Admin promotion gifts')}</h1>

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
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>
				
				<tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea rows="3" cols="3" name="description"></textarea></td>
                </tr>
				
                <tr>
                    <td class="left">{get_label('image')}</td>
                    <td class="left"><input type="hidden" name="image" value="" />
                    	<div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('total_item')}</td>
                    <td class="left"><input type="text" name="total_item" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('used_item')}</td>
                    <td class="left"><input type="text" name="used_item" value="" /></td>
                </tr>

<!--                <tr>-->
<!--                    <td class="left">{get_label('ip')}</td>-->
<!--                    <td class="left"><input type="text" name="ip" value="" /></td>-->
<!--                </tr>-->
            	
            	<tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
