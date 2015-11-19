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
    <h1>{lang('Edit Admin faqs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditFaqs').submit();" class="button"><span>{lang('Edit')}</span></a>
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
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="{$data_edit->email}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('question')}</td>
                   
                     <td class="left"> <textarea name="question">{$data_edit->question}</textarea></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
