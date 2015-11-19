
{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Webservices
 * 
 * @package PenguinFW
 * @subpackage webservices
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add webservices')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddWebservices').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}    
    
    <form action="" method="post" id="FormAddWebservices">
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('public_key')}</td>
                    <td class="left"><input type="text" name="public_key" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('secret_key')}</td>
                    <td class="left"><input type="text" name="secret_key" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('service')}</td>
                    <td class="left"><input type="text" name="service" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('allow_ip')}</td>
                    <td class="left"><input type="text" name="allow_ip" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('type')}</td>
                    <td class="left">
                        <select name="type">
                            <option value="{$type_get}">GET</option>
                            <option value="{$type_post}">POST</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_public')}</td>
                    <td class="left">
                        <select name="is_public">                            
                            <option value="0">No</option>
                            <option value="1">Yes</option>                            
                        </select>
                    </td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
