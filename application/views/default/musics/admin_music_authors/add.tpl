
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
    <h1>{lang('Add Admin music authors')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
        
    <form action="" method="post" id="FormAddMusics" enctype="multipart/form-data">        
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
                    <td class="left">{get_label('avatar')}</td>
                    <td class="left">
                        <input type="hidden" name="avatar" value="" />
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>                        
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description"></textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="" /></td>
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