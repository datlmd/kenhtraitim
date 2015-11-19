<?php /* Smarty version Smarty-3.1.1, created on 2015-04-16 16:14:42
         compiled from "application/views/default\films\admin_films\add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6726552395f4312790-27689198%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15f659159dcb3307171ae8fcc56ce0ab60f184b6' => 
    array (
      0 => 'application/views/default\\films\\admin_films\\add.tpl',
      1 => 1429175678,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6726552395f4312790-27689198',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552395f43d9b1',
  'variables' => 
  array (
    'parent_ids' => 0,
    'category_html' => 0,
    'indent_symbol' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552395f43d9b1')) {function content_552395f43d9b1($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Add Admin films');?>
</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddFilms').submit();" class="button"><span><?php echo lang('Save');?>
</span></a>
    </div>
</div>

<div class="content">
    <?php echo validation_errors();?>

    
    
    <form action="" method="post" id="FormAddFilms">
        <table class="list">
            <tbody>            
                <tr>
                    <td class="left"><?php echo get_label('name');?>
</td>
                    <td class="left"><input type="text" name="name" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('name_en');?>
</td>
                    <td class="left"><input type="text" name="name_en" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('category');?>
</td>
                    <td class="left">
                    	<textarea id="category" name="category"></textarea>
                    	<select id="category_list" onChange="Expedisi(this);">
                            <option value="0"><?php echo lang('Select category');?>
</option>
                            <?php $_smarty_tpl->tpl_vars['category_html'] = new Smarty_variable('<option value="##NAME##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>', null, 0);?>
                            <?php $_smarty_tpl->tpl_vars['indent_symbol'] = new Smarty_variable('-&nbsp;', null, 0);?>
                            <?php echo draw_tree_category_block($_smarty_tpl->tpl_vars['parent_ids']->value,$_smarty_tpl->tpl_vars['category_html']->value,0,$_smarty_tpl->tpl_vars['indent_symbol']->value);?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('actor');?>
</td>
                    <td class="left"><input type="text" name="actor" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('director');?>
</td>
                    <td class="left"><input type="text" name="director" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('year');?>
</td>
                    <td class="left"><input type="text" name="year" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('time');?>
</td>
                    <td class="left"><input type="text" name="time" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('point_imdb');?>
</td>
                    <td class="left"><input type="text" name="point_imdb" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('title');?>
</td>
                    <td class="left"><input type="text" name="subtitle" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('country');?>
</td>
                    <td class="left"><input type="text" name="country" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('quality');?>
</td>
                    <td class="left"><input type="text" name="quality" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('image');?>
</td>
                    <td class="left"><input type="text" name="image" value="" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('image_small');?>
</td>
                    <td class="left"><input type="text" name="image_small" value="" /></td>
                </tr>

				<tr>
                    <td class="left"><?php echo get_label('trailer');?>
</td>
                    <td class="left"><input type="text" name="trailer" value="" /></td>
                </tr>
                
                <tr>
                    <td class="left"><?php echo get_label('description');?>
</td>
                    <td class="left">
                    	<textarea name="description"></textarea>                    
                    </td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('link_download');?>
</td>
                    <td class="left"><textarea name="link_download"></textarea></td>
                </tr>                
                           
                <tr>
                    <td class="left"><?php echo get_label('online');?>
</td>
                    <td class="left"><textarea name="online"></textarea></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('is_hot');?>
</td>
                    <td class="left">
                    	<select name="is_hot">
	                        <option value="0">No</option>
	                        <option value="1">Hot</option>
	                        <option value="2">Focus</option>
	                    </select>
                    </td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('status');?>
</td>
                    <td class="left">
                    	<select name="status">
	                        <option value="0">Pending</option>
	                        <option value="1">Approved</option>
	                        <option value="2">Rejected</option>
	                    </select>
                    </td>
                </tr>
                

                <tr>
                    <td class="left"><?php echo get_label('meta_keyword');?>
</td>
                    <td class="left">
                    	<textarea name="meta_keyword"></textarea>                    
                    </td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('meta_description');?>
</td>
                    <td class="left"><textarea name="meta_description"></textarea></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('weight');?>
</td>
                    <td class="left"><input type="text" name="weight" value="" /></td>
                </tr>
            
            	<tr>
                    <td class="left"><?php echo get_label('username');?>
</td>
                    <td class="left"><input type="text" name="username" value="" /></td>
                </tr>
                
                <tr>
                    <td class="left"><?php echo get_label('Tag');?>
</td>
                    <td class="left"><input type="text" name="data1" value="" /></td>
                </tr>
            </tbody>
        </table>
    </form>

</div>
<script tyle="text/javascript">
    CKEDITOR.replace('description', {
        customConfig : 'custom/musics_basic.js',
        height: '400px'
    });
    CKEDITOR.replace('link_download', {
        customConfig : 'custom/musics_basic.js'
    });
    CKEDITOR.replace('online', {
        customConfig : 'custom/musics_basic.js'
    });
    function Expedisi(t) 
    {
       var y=document.getElementById("category");
       if(y.value.length < 1)
       	   y.value = t.value;
       else
    	   y.value = y.value  + ',' + t.value;
     }
</script>   
<?php }} ?>