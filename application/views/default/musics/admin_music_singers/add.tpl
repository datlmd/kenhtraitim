
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add music singers')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    

    <form action="" method="post" id="FormAddMusics">
        <input type="hidden" name="is_popup" value="{$is_popup}" />
        <input type="hidden" name="insert_id" value="{$smarty.get.insert_id}" />
        <input type="hidden" name="insert_name" value="{$smarty.get.insert_name}" />        
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('SBD')}</td>
                    <td class="left"><input type="text" name="candidate_number" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">                        
                        <input type="hidden" name="avatar" value="" />
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>                        
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('dob')}</td>
                    <td class="left"><input type="text" name="dob" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('country')}</td>
                    <td class="left"><input type="text" name="country" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('company')}</td>
                    <td class="left"><input type="text" name="company" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('category')}</td>
                    <td class="left">
                        <select name="category_id[]" multiple="multiple" size="5">                            
                            {foreach $categories as $category}
                                <option value="{$category.id}">{$category.name}</option>
                            {/foreach}
                        </select>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
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