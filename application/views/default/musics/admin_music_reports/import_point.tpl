{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Import point for Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add music point')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span>{lang('Import')}</span></a>
    </div>
</div>

<div class="content">
            
    <form action="" method="post" id="FormAddMusics" enctype="multipart/form-data">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{lang('Exel file')}</td>
                    <td class="left">
                        <input type="hidden" name="exel_file" value="" />                        
                        <div id="btnExelUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="JsFileUpload"></div>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
