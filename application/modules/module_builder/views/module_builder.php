<?php

/**
 * PENGUIN FrameWork
 * View
 * Add module resource into FW
 * 
 * @author      hungtd <tdhungit@gmail.com> 0972014011
 * @copyright   Tran Dinh Hung 2011
 * @package     PenguinFW
 * @subpackage  ModuleBuilder
 * @version     1.0.0
 */
?>

<div class="heading">
    <h1>Module builder</h1>
</div>

<div class="content">
<div style="padding:10px 5px;background:#ccc;clear:both;color:#333;">
    <?php echo form_open('module_builder/index');?>
    <div class="md-error">
        <?php echo validation_errors();?>    
    </div>
    <table class="mb">
        <tr>
            <td width="220px;">Tên module</td>
            <td><input type="text" name="module" /></td>
        </tr>
        
        <tr>
            <td width="220px;">Tên model</td>
            <td><input type="text" name="model" /></td>
        </tr>
        
        <tr>
            <td>Tên table (database)</td>
            <td><input type="text" name="db_table" /></td>        
        </tr>

        <tr>
            <td>Tên controller</td>
            <td><input type="text" name="module_resource" /></td>
        </tr>

        <tr>
            <td>Tên controller chính</td>
            <td><input type="text" name="module_resource_main" /></td>
        </tr>

        <tr style="display:none;">
            <td><?php echo lang('User name');?></td>
            <td><input type="text" name="username" value="<?php echo $this->session->userdata('user_username')?>" /></td>
        </tr>

        <tr style="display:none;">
            <td>Tạo mới Module</td>
            <td><input type="checkbox" name="new_module" value="1" checked="checked" /></td>
        </tr>
        
        <tr style="display:none;">
            <td>Tạo mới Model</td>
            <td><input type="checkbox" name="new_model" value="1" checked="checked" /></td>
        </tr>

        <tr style="display:none;">
            <td>Tạo mới Controller</td>
            <td><input type="checkbox" name="new_resource" value="1" checked="checked" /></td>
        </tr>        

        <tr>
            <td>Update database field</td>
            <td><input type="checkbox" name="insert_field" value="1" checked="checked" /></td>
        </tr>        

        <tr>
            <td> </td>
            <td> </td>
        </tr>

        <tr>
            <td> </td>
            <td><input type="submit" /></td>
        </tr>
    </table>
    <?php echo form_close();?>
</div>
</div>

<style type="text/css">
    table.mb {width:100%;color:#333;}
    table.mb td {vertical-align:top;border-bottom:1px solid #EEEEEE;border-right:1px solid #EEEEEE;padding:3px 5px;}
    table.mb input[type=text] {width:200px;border:1px solid #238EC6;padding:2px;}
    .md-b {padding:0;margin: 0;}
    .mb-field {padding:5px 0;}
    #mb-content-field {}
    .mb-remove-field {padding:0 5px;}
    .md-error p {color:#FF0000;font-weight:700;}
    input[type=submit], input[type=button] {border:1px solid #000000;padding:2px 7px;background-color:#EEEEEE;font-weight:700;}
</style>