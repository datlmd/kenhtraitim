{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Films
 * 
 * @package PenguinFW
 * @subpackage films
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin films')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditFilms').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormEditFilms">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            
                
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('name_en')}</td>
                    <td class="left"><input type="text" name="name_en" value="{$data_edit->name_en}" /></td>
                </tr>

				<tr>
                    <td class="left">{get_label('category')}</td>
                    <td class="left"><input type="text" name="category" value="{$data_edit->category}" />
                    	<select id="category_list" onChange="Expedisi(this);">
                            <option value="0">{lang('Select category')}</option>
                            {$category_html = '<option value="##NAME##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($parent_ids, $category_html, 0, $indent_symbol)}
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{$data_edit->slug}" /></td>
                </tr>
                

                <tr>
                    <td class="left">{get_label('actor')}</td>
                    <td class="left"><input type="text" name="actor" value="{$data_edit->actor}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('director')}</td>
                    <td class="left"><input type="text" name="director" value="{$data_edit->director}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('year')}</td>
                    <td class="left"><input type="text" name="year" value="{$data_edit->year}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time')}</td>
                    <td class="left"><input type="text" name="time" value="{$data_edit->time}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('point_imdb')}</td>
                    <td class="left"><input type="text" name="point_imdb" value="{$data_edit->point_imdb}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('Title')}</td>
                    <td class="left"><input type="text" name="subtitle" value="{$data_edit->subtitle}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('country')}</td>
                    <td class="left"><input type="text" name="country" value="{$data_edit->country}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('quality')}</td>
                    <td class="left"><input type="text" name="quality" value="{$data_edit->quality}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('trailer')}</td>
                    <td class="left"><input type="text" name="trailer" value="{$data_edit->trailer}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image')}</td>
                    <td class="left"><input type="text" name="image" value="{$data_edit->image}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image_small')}</td>
                    <td class="left"><input type="text" name="image_small" value="{$data_edit->image_small}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><textarea name="description">{$data_edit->description}</textarea></td>
                </tr>

<!--                <tr>-->
<!--                    <td class="left">{get_label('link_sub')}</td>-->
<!--                    <td class="left"><input type="text" name="link_sub" value="{$data_edit->link_sub}" /></td>-->
<!--                </tr>-->

                <tr>
                    <td class="left">{get_label('link_download')}</td>
                    <td class="left"><textarea name="link_download">{$data_edit->link_download}</textarea></td>
                </tr> 
                               
				<tr>
                    <td class="left">{get_label('online')}</td>
                    <td class="left"><textarea name="online">{$data_edit->online}</textarea></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('is_hot')}</td>
                    <td class="left">
                    	<select name="is_hot">
	                        <option value="0" {if $data_edit->is_hot ==0}selected{/if}>No</option>
	                        <option value="1" {if $data_edit->is_hot ==1}selected{/if}>Hot</option>
	                        <option value="2" {if $data_edit->is_hot ==2}selected{/if}>Focus</option>
	                    </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('status')}</td>
                    <td class="left">
                    	<select name="status">
	                        <option value="0" {if $data_edit->status ==0}selected{/if}>Pending</option>
	                        <option value="1" {if $data_edit->status ==1}selected{/if}>Approved</option>
	                        <option value="2" {if $data_edit->status ==2}selected{/if}>Rejected</option>
	                    </select>
                    </td>
                </tr>
				
				<tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left"><textarea name="meta_keyword">{$data_edit->meta_keyword}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{$data_edit->meta_description}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="{$data_edit->weight}" /></td>
                </tr>
                
				<tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="{$data_edit->username}" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('Tag')}</td>
                    <td class="left"><input type="text" name="data1" value="{$data_edit->data1}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('counter_view')}</td>
                    <td class="left"><input type="text" name="counter_view" value="{$data_edit->counter_view}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('counter_vote')}</td>
                    <td class="left"><input type="text" name="counter_vote" value="{$data_edit->counter_vote}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('counter_like')}</td>
                    <td class="left"><input type="text" name="counter_like" value="{$data_edit->counter_like}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('counter_comment')}</td>
                    <td class="left"><input type="text" name="counter_comment" value="{$data_edit->counter_comment}" /></td>
                </tr>
            
            </tbody>
        </table>
    </form>

</div>
<script tyle="text/javascript">
    //CKEDITOR.replace('description', {
    //    customConfig : 'custom/musics_basic.js',
    //    height: '400px'
    //});
    CKEDITOR.replace('link_download', {
        customConfig : 'custom/musics_basic.js'
    });
    CKEDITOR.replace('online', {
        customConfig : 'custom/musics_basic.js',
        height: '400px'
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