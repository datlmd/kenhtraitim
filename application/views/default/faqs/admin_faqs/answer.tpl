{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Faqs
 * 
 * @package PenguinFW
 * @subpackage faqs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Answer Admin faqs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditFaqs').submit();" class="button"><span>{lang('Answer')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormEditFaqs">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left">{$data_edit->name}</td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left">{$data_edit->email}</td>
                </tr>

                <tr>
                    <td class="left">{get_label('created')}</td>
                    <td class="left">{$data_edit->created}</td>
                </tr>

                <tr>
                    <td class="left">{get_label('question')}</td>                  
                    <td class="left">{$data_edit->question}</td>
                </tr>

                <tr>
                    <td class="left">{get_label('answer')}</td>                  
                    <td class="left"> <textarea name="answer" style="width: 400px; height: 100px">{$data_edit->answer}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('approve')}</td>                  
                    <td class="left"> <input type="checkbox" name="status" value="1" checked="checked"/></td>
                </tr>

            </tbody>
        </table>
    </form>

</div>

<script type="text/javascript">
    $(document).ready(function() {
	
    CKEDITOR.replace('answer', {
    customConfig : 'custom/config_admin.js'

});

});
</script>
