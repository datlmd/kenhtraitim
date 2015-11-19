<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:58:30
         compiled from "application/views/default\musics\admin_music_categories\add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1106155239c362d3f90-34257045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ad70591d3cffebd553fab0264b3707a620c0ba1' => 
    array (
      0 => 'application/views/default\\musics\\admin_music_categories\\add.tpl',
      1 => 1425626157,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1106155239c362d3f90-34257045',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'parent_ids' => 0,
    'category_html' => 0,
    'indent_symbol' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_55239c3634541',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55239c3634541')) {function content_55239c3634541($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Add Admin music categories');?>
</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddMusics').submit();" class="button"><span><?php echo lang('Save');?>
</span></a>
    </div>
</div>

<div class="content">
    <?php echo validation_errors();?>

    
    
    <form action="" method="post" id="FormAddMusics">
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left"><?php echo get_label('name');?>
</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('slug');?>
</td>
                    <td class="left"><input type="text" name="slug" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('description');?>
</td>
                    <td class="left"><textarea name="description"></textarea></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('parent_id');?>
</td>
                    <td class="left">
                        <select name="parent_id">
                            <option value="0"><?php echo lang('Select category');?>
</option>
                            <?php $_smarty_tpl->tpl_vars['category_html'] = new Smarty_variable('<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>', null, 0);?>
                            <?php $_smarty_tpl->tpl_vars['indent_symbol'] = new Smarty_variable('-&nbsp;', null, 0);?>
                            <?php echo draw_tree_category_block($_smarty_tpl->tpl_vars['parent_ids']->value,$_smarty_tpl->tpl_vars['category_html']->value,0,$_smarty_tpl->tpl_vars['indent_symbol']->value);?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('weight');?>
</td>
                    <td class="left"><input type="text" name="weight" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('meta_keyword');?>
</td>
                    <td class="left"><textarea name="meta_keyword"></textarea></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('meta_description');?>
</td>
                    <td class="left"><textarea name="meta_description"></textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>

<script tyle="text/javascript">
    CKEDITOR.replace('description', {
        customConfig : 'custom/musics_basic.js'
    });
</script>                    <?php }} ?>