<?php /* Smarty version Smarty-3.1.1, created on 2015-04-16 14:06:22
         compiled from "application/views/default\films\admin_films\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10794552f5f6e7679b9-66626446%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '16992fb8c0562fa963ef833d872191d233248eee' => 
    array (
      0 => 'application/views/default\\films\\admin_films\\edit.tpl',
      1 => 1428395490,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10794552f5f6e7679b9-66626446',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data_edit' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_552f5f6e8b793',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552f5f6e8b793')) {function content_552f5f6e8b793($_smarty_tpl) {?>

<div class="heading">
    <h1><?php echo lang('Edit Admin films');?>
</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditFilms').submit();" class="button"><span><?php echo lang('Edit');?>
</span></a>
    </div>
</div>

<div class="content">
    <?php echo validation_errors();?>

    
    
    <form action="" method="post" id="FormEditFilms">
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->id;?>
" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left"><?php echo get_label('username');?>
</td>
                    <td class="left"><input type="text" name="username" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->username;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('name');?>
</td>
                    <td class="left"><input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->name;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('name_en');?>
</td>
                    <td class="left"><input type="text" name="name_en" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->name_en;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('description');?>
</td>
                    <td class="left"><input type="text" name="description" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->description;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('content');?>
</td>
                    <td class="left"><input type="text" name="content" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->content;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('slug');?>
</td>
                    <td class="left"><input type="text" name="slug" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->slug;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('category');?>
</td>
                    <td class="left"><input type="text" name="category" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->category;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('actor');?>
</td>
                    <td class="left"><input type="text" name="actor" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->actor;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('director');?>
</td>
                    <td class="left"><input type="text" name="director" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->director;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('year');?>
</td>
                    <td class="left"><input type="text" name="year" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->year;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('time');?>
</td>
                    <td class="left"><input type="text" name="time" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->time;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('point_imdb');?>
</td>
                    <td class="left"><input type="text" name="point_imdb" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->point_imdb;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('subtitle');?>
</td>
                    <td class="left"><input type="text" name="subtitle" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->subtitle;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('country');?>
</td>
                    <td class="left"><input type="text" name="country" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->country;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('quality');?>
</td>
                    <td class="left"><input type="text" name="quality" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->quality;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('image');?>
</td>
                    <td class="left"><input type="text" name="image" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->image;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('image_small');?>
</td>
                    <td class="left"><input type="text" name="image_small" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->image_small;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('link_sub');?>
</td>
                    <td class="left"><input type="text" name="link_sub" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->link_sub;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('link_download');?>
</td>
                    <td class="left"><input type="text" name="link_download" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->link_download;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('trailer');?>
</td>
                    <td class="left"><input type="text" name="trailer" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->trailer;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('link_torrent');?>
</td>
                    <td class="left"><input type="text" name="link_torrent" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->link_torrent;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('note');?>
</td>
                    <td class="left"><input type="text" name="note" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->note;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('is_hot');?>
</td>
                    <td class="left"><input type="checkbox" name="is_hot" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->is_hot;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('is_allow_comment');?>
</td>
                    <td class="left"><input type="checkbox" name="is_allow_comment" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->is_allow_comment;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('status');?>
</td>
                    <td class="left"><input type="text" name="status" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->status;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('counter_view');?>
</td>
                    <td class="left"><input type="text" name="counter_view" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->counter_view;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('counter_vote');?>
</td>
                    <td class="left"><input type="text" name="counter_vote" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->counter_vote;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('counter_like');?>
</td>
                    <td class="left"><input type="text" name="counter_like" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->counter_like;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('counter_comment');?>
</td>
                    <td class="left"><input type="text" name="counter_comment" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->counter_comment;?>
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

                <tr>
                    <td class="left"><?php echo get_label('weight');?>
</td>
                    <td class="left"><input type="text" name="weight" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->weight;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('online');?>
</td>
                    <td class="left"><input type="text" name="online" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->online;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('data1');?>
</td>
                    <td class="left"><input type="text" name="data1" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->data1;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('data2');?>
</td>
                    <td class="left"><input type="text" name="data2" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->data2;?>
" /></td>
                </tr>

                <tr>
                    <td class="left"><?php echo get_label('data3');?>
</td>
                    <td class="left"><input type="text" name="data3" value="<?php echo $_smarty_tpl->tpl_vars['data_edit']->value->data3;?>
" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
<?php }} ?>