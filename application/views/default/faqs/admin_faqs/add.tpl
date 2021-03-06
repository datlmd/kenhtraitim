{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Faqs
 * 
 * @package PenguinFW
 * @subpackage faqs
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin faqs')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddFaqs').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormAddFaqs">
        <table class="list">
            <tbody>            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('email')}</td>
                    <td class="left"><input type="text" name="email" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('question')}</td>
                    <td class="left"> <textarea name="question"></textarea></td>

                </tr>

            </tbody>
        </table>
    </form>

</div>
