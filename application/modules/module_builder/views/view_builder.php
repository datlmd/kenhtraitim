<?php

/**
 * PENGUIN FrameWork
 * View Build View page width Smarty
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  ModuleBuilder
 * @version     1.0.0
 */
?>

<div class="heading">
    <h1>Module View builder</h1>
</div>

<div class="content">
<div style="padding:10px 5px;background:#ccc;clear:both;color:#333;">
    <div class="md-error">
        <?php echo validation_errors();?>    
    </div>

    <form action="" method="post">    
        <table class="mb">
            <tr>
                <td>Module Resource</td>
                <td><input type="text" name="resource" /></td>
            </tr>
            <tr>
                <td>Main module Resource</td>
                <td><input type="text" name="main_resource" /></td>
            </tr>
            <tr>
                <td>Template name</td>
                <td><input type="text" name="view_name" /></td>
            </tr>        
            <tr>
                <td>Action link [Add form]</td>
                <td><input type="text" name="form_link" /></td>
            </tr>
            <tr>
                <td>Search form</td>
                <td><input type="checkbox" name="is_search_form" value="1" /></td>
            </tr>
            <tr>
                <td>Field search [ ; ]</td>
                <td><input type="text" name="field_search" /></td>
            </tr>        
            <tr>
                <td>Copy from</td>
                <td>
                    <select name="template_view">
                        <option value="index">INDEX</option>
                        <option value="view">VIEW</option>
                        <option value="add">ADD</option>
                        <option value="edit">EDIT</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td></td>
                <td><p style="height:20px;">&nbsp;</p><input type="submit" value=" ADD VIEW " /></td>
            </tr>
        </table>
    </form>
</div>
</div>

<style type="text/css">
    table.mb {width:100%;}
    table.mb td {vertical-align:top;border-bottom:1px solid #EEEEEE;border-right:1px solid #EEEEEE;padding:3px 5px;}
    table.mb input[type=text] {width:200px;border:1px solid #238EC6;padding:2px;}
    .md-b {padding:0;margin: 0;}
    .mb-field {padding:5px 0;}
    #mb-content-field {}
    .mb-remove-field {padding:0 5px;}
    .md-error p {color:#FF0000;font-weight:700;}
    input[type=submit], input[type=button] {border:1px solid #000000;padding:2px 7px;background-color:#EEEEEE;font-weight:700;}
</style>