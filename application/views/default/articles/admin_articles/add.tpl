
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * ADD article
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Add Admin article')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormAddUsers').submit();" class="button"><span>{lang('Save')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}
    
    <div class="vtabs">
            <a href="#vtab-general">{lang('General')}</a>
            <a href="#vtab-language">{lang('Language')}</a>
        </div>
        
    <form action="" method="post" id="FormAddUsers">
        <div id="vtab-general" class="vtabs-content">
	        <table class="list">
	           <tr>
                    <td class="left"><span class="required">*</span> {get_label('thumbnail_image')}</td>
                    <td class="left">
                        <input type="hidden" name="thumbnail_image" value="{set_value('thumbnail_image')}" />
                        {if $smarty.post.thumbnail_image == FALSE}
                        <div id="btnAvatarUpload" class="button-upload">{lang('Upload')}</div>
                        <div class="image-medium-thum"></div>
                        {else}
                        <div class="image-medium-thum"><img src="{image_url()|cat:set_value('thumbnail_image')}"/></div>
                        {/if}
                    </td>
                </tr>
                
                <tr>
                    <td class="left"><span class="required">*</span> {get_label('category')}</td>
                    <td class="left">
                        <select name="category_ids[]" multiple="multiple" size="8">
                            {$category_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                            {$indent_symbol = '-&nbsp;'}
                            {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, $smarty.post.category_ids)}
                        </select>
                    </td>
                </tr>
                
	            <tr>
	                <td class="left">{get_label('is_allow_comment')}</td>
	                <td class="left">
	                    <select name="is_allow_comment">
	                        {foreach $comment_ids as $key_comment => $comment}
	                            <option value="{$key_comment}" {set_select('is_allow_comment', $key_comment)}>{$comment}</option>
	                        {/foreach}
	                    </select>
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="left">{get_label('is_hot')}</td>
	                <td class="left">
	                    <select name="is_hot">
	                        {foreach $hot_ids as $key_hot => $hot}
	                            <option value="{$key_hot}" {set_select('is_hot',$key_hot)}>{$hot}</option>
	                        {/foreach}
	                    </select>
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="left">{get_label('is_publish')}</td>
	                <td class="left">
	                    <select name="is_publish">
	                        {foreach $publish_ids as $key_publish => $publish}
	                            <option value="{$key_publish}" {set_select('is_hot',$key_publish)}>{$publish}</option>
	                        {/foreach}
	                    </select>
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="left">{get_label('publish_date')}</td>
	                <td class="left">
                            <input type="text" value="{set_value('publish_date',date('d-m-Y'))}" class="pgDate" name="publish_date" />
	                   <input type="text"   value="{set_value('publish_time',date('H:i'))}" class="pgTime" name="publish_time" />
	                </td>
	            </tr>
	        </table>
        </div>
        
        <div id="vtab-language" class="vtabs-content">
        <div id="tabs" class="htabs">
            {foreach $lang_list as $lang}
                <a href="#tab-lang-{$lang.code}">{lang($lang.name)}</a>
            {/foreach}
        </div>
        
        {foreach $lang_list as $lang}
            <div id="tab-lang-{$lang.code}">
	            <table class="list">
		            <tbody>            
		                
		                <tr>
		                    <td class="left">{get_label('subject')}</td>
                                    <td class="left" style="width: 85%;"><input type="text" name="subject_{$lang.code}" value="{set_value('subject_'|cat:$lang.code)}" /></td>
		                </tr>                             
		
		                <tr>
		                    <td class="left">{get_label('teaser')}</td>
		                    <td class="left">
		                       <textarea rows="5" cols="33" name="teaser_{$lang.code}">{set_value('teaser_'|cat:$lang.code)}</textarea>
	                        </td>
		                </tr>
		                
		                <tr>
	                        <td class="left">{get_label('content')}</td>
	                        <td class="left" style="height: 700px;">
	                           <textarea rows="5" cols="33" name="content_{$lang.code}">{set_value('content_'|cat:$lang.code)}</textarea>
	                        </td>
	                    </tr>
	                    
	                    <tr>
	                        <td class="left">{get_label('tags')}</td>
	                        <td class="left"><input type="text" name="tags" value="{set_value('tags')}" /></td>
	                    </tr>
		
		                <tr>
		                    <td class="left">{get_label('slug')}</td>
		                    <td class="left"><input type="text" name="slug" maxlength="255" value="{set_value('slug')}" /></td>
		                </tr>
		
		               <tr>
	                        <td class="left">{get_label('seo_subject')}</td>
	                        <td class="left"><input type="text" name="seo_subject_{$lang.code}" value="" /></td>
	                   </tr>
	                    
	                    <tr>
	                        <td class="left">{get_label('seo_description')}</td>
	                        <td class="left">
	                            <textarea rows="3" cols="150" name="seo_description_{$lang.code}"></textarea>
	                        </td>
	                    </tr>
	                    
	                    <tr>
	                        <td class="left">{get_label('seo_keyword')}</td>
	                        <td class="left"><input type="text" name="seo_keyword_{$lang.code}" value="" /></td>
	                   </tr>
		                         
		            </tbody>
		        </table>
	        </div>
        {/foreach}
        </div>
    </form>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#tabs a').tabs();
	$('.vtabs a').tabs();
	
	{foreach $lang_list as $lang}
	    CKEDITOR.replace('content_{$lang.code}', {
	        customConfig : 'custom/config_admin.js',
	        filebrowserBrowseUrl: '{base_url()}articles/admin_article_filemanager',
	        filebrowserImageBrowseUrl: '{base_url()}articles/admin_article_filemanager',
	        height: '600px'
	    });
	{/foreach}
});
</script>
 