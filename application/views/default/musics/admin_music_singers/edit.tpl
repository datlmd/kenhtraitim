
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit music singers')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMusics').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    

    <form action="" method="post" id="FormEditMusics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('SBD')}</td>
                    <td class="left"><input type="text" name="candidate_number" value="{$data_edit->candidate_number}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">                        
                        <input type="hidden" name="avatar" value="{$data_edit->avatar}" />
                        <div id="btnAvatarUpload" class="button-upload" {if $data_edit->avatar neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
                        <div class="image-medium-thum" {if $data_edit->avatar eq ''}style="display:none;"{/if}>
                            <img src="{base_url()}media/images/{get_image_thumb($data_edit->avatar, 'small_thumb')}" />
                            <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
                        </div>                        
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" value="{$data_edit->dob}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('country')}</td>
                    <td class="left"><input type="text" name="country" value="{$data_edit->country}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('category')}</td>
                    <td class="left">

                        <select name="category_id[]" multiple="multiple" size="5">                            
                            {foreach $categories as $category}
                                <option value="{$category.id}" {if in_array($category.id, $selected_cate_ids)}selected{/if}>{$category.name}</option>
                            {/foreach}
                  
                        </select>
                </tr>

                <tr>
                    <td class="left">{get_label('company')}</td>
                    <td class="left"><input type="text" name="company" value="{$data_edit->company}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$data_edit->weight}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>                

            </tbody>
        </table>
    </form>

</div>

<script tyle="text/javascript">
    CKEDITOR.replace('description', {
    customConfig : 'custom/musics_basic.js'
});
</script>                