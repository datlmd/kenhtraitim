{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Films
 * 
 * @package PenguinFW
 * @subpackage films
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin films')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddFilms').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    
    <form action="" method="post" id="FormAddFilms">
        <table class="list">
            <tbody>            
                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$title}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('name_en')}</td>
                    <td class="left"><input type="text" name="name_en" value="{$title}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('category')}</td>
                    <td class="left">
                    	<textarea id="category" name="category"></textarea>
                    	<select id="category_list" onChange="Expedisi(this);">
                            <option value="0">{lang('Select category')}</option>
                            {$category_html = '<option value="##NAME##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($parent_ids, $category_html, 0, $indent_symbol)}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('actor')}</td>
                    <td class="left"><input type="text" name="actor" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('director')}</td>
                    <td class="left"><input type="text" name="director" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('year')}</td>
                    <td class="left"><input type="text" name="year" value="2014" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('time')}</td>
                    <td class="left"><input type="text" name="time" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('point_imdb')}</td>
                    <td class="left"><input type="text" name="point_imdb" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('title')}</td>
                    <td class="left"><input type="text" name="subtitle" value="Sub Việt" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('country')}</td>
                    <td class="left"><input type="text" name="country" value="Mỹ" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('quality')}</td>
                    <td class="left"><input type="text" name="quality" value="HD" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image')}</td>
                    <td class="left"><input type="text" name="image" value="" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('image_small')}</td>
                    <td class="left"><input type="text" name="image_small" value="http://taiphimhd.net/sites/default/files/imagecache/thumbhomepage/images/" /></td>
                </tr>

				<tr>
                    <td class="left">{get_label('trailer')}</td>
                    <td class="left"><input type="text" name="trailer" value="http://www.youtube.com/embed/V8?rel=0&showinfo=0" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left">
                    	<textarea name="description" style="height:400px;">{$youtube}</textarea>                    
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('link_download')}</td>
                    <td class="left"><textarea name="link_download">{$download}</textarea></td>
                </tr>                
                           
                <tr>
                    <td class="left">{get_label('online')}</td>
                    <td class="left"><textarea name="online">{$content}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('is_hot')}</td>
                    <td class="left">
                    	<select name="is_hot">
	                        <option value="0">No</option>
	                        <option value="1">Hot</option>
	                        <option value="2">Focus</option>
	                    </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('status')}</td>
                    <td class="left">
                    	<select name="status">
	                        <!--<option value="0">Pending</option>-->
	                        <option value="1">Approved</option>
	                        <option value="2">Rejected</option>
	                    </select>
                    </td>
                </tr>
                

                <tr>
                    <td class="left">{get_label('meta_keyword')}</td>
                    <td class="left">
                    	<textarea name="meta_keyword">{$meta_key}</textarea>                    
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('meta_description')}</td>
                    <td class="left"><textarea name="meta_description">{$meta_des}</textarea></td>
                </tr>

                <tr>
                    <td class="left">{get_label('weight')}</td>
                    <td class="left"><input type="text" name="weight" value="0" /></td>
                </tr>
            
            	<tr>
                    <td class="left">{get_label('username')}</td>
                    <td class="left"><input type="text" name="username" value="legiaminh86" /></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('Tag')}</td>
                    <td class="left"><input type="text" name="data1" value="{$meta_key}" /></td>
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
