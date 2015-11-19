<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:25:48
         compiled from "application/views/default\musics\admin_music_categories\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26155523948cc4bd41-73907932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ecec3dc83c95a6fb20bab7bb64740a3fd0d1476' => 
    array (
      0 => 'application/views/default\\musics\\admin_music_categories\\edit.tpl',
      1 => 1425626157,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26155523948cc4bd41-73907932',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data_edit' => 0,
    'parent_ids' => 0,
    'category_html' => 0,
    'indent_symbol' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_5523948cd8c2c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5523948cd8c2c')) {function content_5523948cd8c2c($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Edit Admin music categories');?>
</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMusics').submit();" class="button"><span><?php echo lang('Edit');?>
</span></a>
    </div>
</div>

<div class="content">
    <?php echo validation_errors();?>

        
    <form action="" method="post" id="FormEditMusics">
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->id;?>
" />
        <table class="list">
            <tbody>                                            

                <tr>
                    <td class="left"><?php echo get_label('name');?>
</td>
                    <td class="left"><input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->name;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('slug');?>
</td>
                    <td class="left"><input type="text" name="slug" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->slug;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('description');?>
</td>
                    <td class="left"><textarea name="description"><?php echo $_smarty_tpl->tpl_vars['data_edit']->value->description;?>
</textarea></td>
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
                            <?php echo draw_tree_category_block($_smarty_tpl->tpl_vars['parent_ids']->value,$_smarty_tpl->tpl_vars['category_html']->value,0,$_smarty_tpl->tpl_vars['indent_symbol']->value,array($_smarty_tpl->tpl_vars['data_edit']->value->parent_id));?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('weight');?>
</td>
                    <td class="left"><input type="text" name="weight" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->weight;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('meta_keyword');?>
</td>
                    <td class="left"><textarea name="meta_keyword"><?php echo $_smarty_tpl->tpl_vars['data_edit']->value->meta_keyword;?>
</textarea></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('meta_description');?>
</td>
                    <td class="left"><textarea name="meta_description"><?php echo $_smarty_tpl->tpl_vars['data_edit']->value->meta_description;?>
</textarea></td>
                </tr>                
            
            </tbody>
        </table>
    </form>

</div>

<script tyle="text/javascript">
    CKEDITOR.replace('description', {
        customConfig : 'custom/musics_basic.js'
    });
</script>                                    <?php }} ?>