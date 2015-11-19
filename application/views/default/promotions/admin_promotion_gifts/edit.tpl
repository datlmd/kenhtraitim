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
    <h1>{lang('Edit Admin promotion gifts')}</h1>

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
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>
                
                 <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea rows="3" cols="3" name="description">{$data_edit->description}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image')}</td>
                    <td class="left"><input type="hidden" name="image" value="{$data_edit->image}" />
                    	<div id="btnAvatarUpload" class="button-upload" {if $data_edit->image neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
	                    <div class="image-medium-thum" {if $data_edit->image eq ''}style="display:none;"{/if}>
	                       <a href="{img_url()}media/images/{$data_edit->image}" rel="shadowbox">
                                <img src="{base_url()}media/images/{get_image_thumb($data_edit->image, 'small_thumb')}" />
                            </a>
	                        <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
	                    </div>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('total_item')}</td>
                    <td class="left"><input type="text" name="total_item" value="{$data_edit->total_item}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('used_item')}</td>
                    <td class="left"><input type="text" name="used_item" value="{$data_edit->used_item}" /></td>
                </tr>
            
            	<tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
