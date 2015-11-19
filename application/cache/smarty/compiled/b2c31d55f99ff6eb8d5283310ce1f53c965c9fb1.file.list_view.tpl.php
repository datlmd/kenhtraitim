<?php /* Smarty version Smarty-3.1.1, created on 2015-04-07 15:31:45
         compiled from "D:\xampp\htdocs\2015\film\application\views\default\elements\list_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24265552395f16eec19-28892769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2c31d55f99ff6eb8d5283310ce1f53c965c9fb1' => 
    array (
      0 => 'D:\\xampp\\htdocs\\2015\\film\\application\\views\\default\\elements\\list_view.tpl',
      1 => 1425626160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24265552395f16eec19-28892769',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'total_records' => 0,
    'fields' => 0,
    'field' => 0,
    'list_views' => 0,
    'list_view' => 0,
    'field_type' => 0,
    'value' => 0,
    'link_edit' => 0,
    'list_params' => 0,
    'param' => 0,
    'params' => 0,
    'pagination_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552395f182f11',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552395f182f11')) {function content_552395f182f11($_smarty_tpl) {?>
<div id="total_records" style="width: 30%; text-align: left ; color:blue; font-weight: bold; font-size: 18px;" >Total: <?php if ($_smarty_tpl->tpl_vars['total_records']->value){?><?php echo $_smarty_tpl->tpl_vars['total_records']->value;?>
<?php }else{ ?>0<?php }?> records</div>
<table class="list">
    <?php if ($_smarty_tpl->tpl_vars['fields']->value==false){?>
        <tbody>
            <tr><td class="left"><?php echo lang('No record');?>
</td></tr>
        </tbody>
    <?php }else{ ?>
        <thead>
            <tr>
                <td class="left"><input type="checkbox" name="AllSelect" value="1" class="JsListViewId" /></td>
                    <?php  $_smarty_tpl->tpl_vars['field_type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_type']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_type']->key => $_smarty_tpl->tpl_vars['field_type']->value){
$_smarty_tpl->tpl_vars['field_type']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['field_type']->key;
?>
                    <td class="left" id="head_<?php echo $_smarty_tpl->tpl_vars['field']->value;?>
">
                        <div>
                        <?php echo get_label($_smarty_tpl->tpl_vars['field']->value);?>


                        <?php echo get_filter_img($_smarty_tpl->tpl_vars['field']->value);?>


                        <?php echo get_linked_sort_img($_smarty_tpl->tpl_vars['field']->value);?>

                        </div>
                        <div class="filter_field" id="filter_<?php echo $_smarty_tpl->tpl_vars['field']->value;?>
" style="clear:both; float: left; margin-top: 5px; margin-right: -100px; width: 100%">
                            <?php if ($_GET[$_smarty_tpl->tpl_vars['field']->value]!==''&&$_GET[$_smarty_tpl->tpl_vars['field']->value]!==null){?>&lbrack;<input <?php if ($_smarty_tpl->tpl_vars['field']->value=='created'||$_smarty_tpl->tpl_vars['field']->value=='modified'||$_smarty_tpl->tpl_vars['field']->value=='dob'){?>class="pgDate"<?php }?> value="<?php echo $_GET[$_smarty_tpl->tpl_vars['field']->value];?>
" name="<?php echo $_smarty_tpl->tpl_vars['field']->value;?>
" type="text" style="outline:none; width:50% ; border: none; background: none; text-align: center;"/>&rbrack;
                            <?php }?>
                        </div>
                    </td>
                <?php } ?>
                <td class="left"><?php echo lang('Action');?>
</td>
            </tr>
        </thead>

        <tbody>
            <?php  $_smarty_tpl->tpl_vars['list_view'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list_view']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_views']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list_view']->key => $_smarty_tpl->tpl_vars['list_view']->value){
$_smarty_tpl->tpl_vars['list_view']->_loop = true;
?>
                <tr>
                    <td class="left">
                        <?php if ($_smarty_tpl->tpl_vars['list_view']->value['id']){?>
                            <input type="checkbox" name="listViewId[]" value="<?php echo $_smarty_tpl->tpl_vars['list_view']->value['id'];?>
" class="listViewId" />
                        <?php }else{ ?>                            
                            <input type="checkbox" name="listViewId[]" value="0" class="listViewId" disabled="disabled" />
                        <?php }?>                        
                    </td>
                    <?php  $_smarty_tpl->tpl_vars['field_type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_type']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_type']->key => $_smarty_tpl->tpl_vars['field_type']->value){
$_smarty_tpl->tpl_vars['field_type']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['field_type']->key;
?>
                        <?php if (is_image_link($_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value])){?>
                            <td class="left">
                                <a class="fancybox" title="<?php echo img_url();?>
media/images/<?php echo $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value];?>
" rel="group" href="<?php echo img_url();?>
media/images/<?php echo $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value];?>
"><img width="140" src="<?php echo img_url();?>
media/images/<?php echo $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value];?>
" /></a>
                            </td>
                        <?php }elseif(is_audio_link($_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value])){?>
                            <td class="left">
                                <div id="show_media_file_<?php echo $_smarty_tpl->tpl_vars['list_view']->value['id'];?>
"></div>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        write_audio_jwplayer('show_media_file_<?php echo $_smarty_tpl->tpl_vars['list_view']->value['id'];?>
', '<?php echo base_url();?>
media/musics/<?php echo $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value];?>
');
                                    });
                                </script>
                            </td>
                        <?php }elseif(is_video_link($_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value])){?>
                            <td class="left">
                                <div id="show_media_file_<?php echo $_smarty_tpl->tpl_vars['list_view']->value['id'];?>
"></div>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        write_video_jwplayer('show_media_file_<?php echo $_smarty_tpl->tpl_vars['list_view']->value['id'];?>
', '<?php echo base_url();?>
media/videos/<?php echo $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value];?>
');
                                    });
                                </script>
                            </td>
                        <?php }elseif(is_file_link($_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value])){?>
                            <td class="left">
                                <a href="<?php echo base_url();?>
media/filemanager/<?php echo $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value];?>
" target="_blank">Download</a>
                            </td>
                        <?php }elseif(is_log_file_link($_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value])){?>
                            <td class="left">
                                <a href="<?php echo base_url();?>
tracking_logs/admin_tracking_logs/view/<?php echo $_smarty_tpl->tpl_vars['list_view']->value['id'];?>
" target="_blank">View logs</a>
                            </td>
                        <?php }else{ ?>
                            <td class="left">
                                <?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(pg_field_value($_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['field']->value],$_smarty_tpl->tpl_vars['field_type']->value), null, 0);?>
                                <?php echo $_smarty_tpl->tpl_vars['value']->value;?>

                            </td>
                        <?php }?>
                    <?php } ?>
                    <td class="left">
                        <?php if ($_smarty_tpl->tpl_vars['list_view']->value['id']){?>
                            <?php echo link_action($_smarty_tpl->tpl_vars['link_edit']->value,$_smarty_tpl->tpl_vars['list_view']->value['id']);?>

                        <?php }else{ ?>
                            <?php $_smarty_tpl->tpl_vars['params'] = new Smarty_variable(array(), null, 0);?>
                            <?php  $_smarty_tpl->tpl_vars['param'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['param']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_params']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['param']->key => $_smarty_tpl->tpl_vars['param']->value){
$_smarty_tpl->tpl_vars['param']->_loop = true;
?>
                                <?php $_smarty_tpl->createLocalArrayVariable('params', null, 0);
$_smarty_tpl->tpl_vars['params']->value[] = $_smarty_tpl->tpl_vars['list_view']->value[$_smarty_tpl->tpl_vars['param']->value];?>
                            <?php } ?>                            
                            <?php echo link_action($_smarty_tpl->tpl_vars['link_edit']->value,$_smarty_tpl->tpl_vars['params']->value);?>

                        <?php }?>
                    </td>
                </tr>
            <?php }
if (!$_smarty_tpl->tpl_vars['list_view']->_loop) {
?>
                <tr>
                    <td class="left" colspan="10"><?php echo lang('No record');?>
</td>
                </tr>
            <?php } ?>            
        </tbody>
    <?php }?>
</table>

<div style="width: 100%; height: 20px;">
    <div style="width:60% ; margin-top: 7px; float: left;"><?php echo $_smarty_tpl->tpl_vars['pagination_link']->value;?>
</div>
    <div id="total_records" style="width: 30%; text-align: right ; color:blue; float:right; font-weight: bold; font-size: 18px;" >Total: <?php if ($_smarty_tpl->tpl_vars['total_records']->value){?><?php echo $_smarty_tpl->tpl_vars['total_records']->value;?>
<?php }else{ ?>0<?php }?> records</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>
<script type="text/javascript">
    function write_audio_jwplayer(id_tag, file_link){
        jwplayer(id_tag).setup({
            file: file_link,
            width: 200,
            height: 80,
            autostart: false,
            primary: 'flash',
            "player": {
                "modes": {
                    "linear": {
                        "controls": {
                            "visible" : false,
                            "enableFullscreen": true,
                            "enablePlay": true,
                            "enablePause": true,
                            "enableMute": true,
                            "enableVolume": true,
                            "height" : 30
                        }
                    }
                }
            }
        });
    }

    function write_video_jwplayer(id_tag, file_link){
        jwplayer(id_tag).setup({
            file: file_link,
            width: 200,
            height: 200,
            autostart: false,
            primary: 'flash',
            "player": {
                "modes": {
                    "linear": {
                        "controls": {
                            "visible" : false,
                            "enableFullscreen": true,
                            "enablePlay": true,
                            "enablePause": true,
                            "enableMute": true,
                            "enableVolume": true,
                            "height" : 30
                        }
                    }
                }
            }
        });
    }
</script><?php }} ?>