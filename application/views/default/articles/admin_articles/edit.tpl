
{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * EDIT article
 * 
 * @package PenguinFW
 * @subpackage users
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin article')}</h1>

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
        {* Assign variable*}
        {$general_info = $articles[$lang_list.0.id]}
        <table class="list">
            <tr>
                <td class="left"><span class="required">*</span> {get_label('thumbnail_image')}</td>
                <td class="left">
                    <input type="hidden" name="thumbnail_image" value="{set_value('thumbnail_image',$general_info.thumbnail_image)}" />
                    <div id="btnAvatarUpload" class="button-upload" {if $general_info.thumbnail_image neq ''}style="display:none;"{/if}>{lang('Upload')}</div>                        
<!--                    <div class="image-medium-thum" {if $general_info.thumbnail_image eq ''}style="display:none;"{/if}>
                        <img src="{base_url()}media/images/{get_image_thumb($general_info.thumbnail_image, 'small_thumb')}" />
                        <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
                    </div>-->
                    
                        {if $smarty.post.thumbnail_image == TRUE}
                        <div class="image-medium-thum"><img src="{image_url()|cat:set_value('thumbnail_image',$general_info.thumbnail_image)}"/></div>
                        {else}
                        <div class="image-medium-thum"><img src="{image_url()|cat:set_value('thumbnail_image',$general_info.thumbnail_image)}"/></div>
                        <a href="javascript:void(0)" class="JsAuthorCancelAvatar">{lang('Remove')}</a>
                        {/if}
                    
                </td>
            </tr>
                
            <tr>
                <td class="left"><span class="required">*</span> {get_label('category')}</td>
                <td class="left">
                    <select name="category_ids[]" multiple="multiple" size="8">
                        {$category_html = '<option value="##VALUE##" ##SELECTED##>##INDENT_SYMBOL####NAME##</option>'}
                        {$indent_symbol = '-&nbsp;'}
                        {draw_tree_category_block($categories, $category_html, 0, $indent_symbol, $selected_category_ids)}
                    </select>
                </td>
            </tr>
                
            <tr>
                <td class="left">{get_label('is_allow_comment')}</td>
                <td class="left">
                    <select name="is_allow_comment">
                        {foreach $comment_ids as $key => $value}
                            <option value="{$key}" {set_select('is_allow_comment', $key, ($key==$general_info.is_allow_comment) ? TRUE : FALSE)}>{$value}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            
            <tr>
                <td class="left">{get_label('is_hot')}</td>
                <td class="left">
                    <select name="is_hot">
                        {foreach $hot_ids as $key => $value}
                            <option value="{$key}"  {set_select('is_hot',$key, ($key==$general_info.is_hot) ? TRUE : FALSE)}>{$value}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            
            <tr>
                <td class="left">{get_label('is_publish')}</td>
                <td class="left">
                    <select name="is_publish">
                        {foreach $publish_ids as $key => $value}
                            <option value="{$key}" {set_select('is_publish',$key, ($key==$general_info.is_publish) ? TRUE : FALSE)}>{$value}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            
            <tr>
                <td class="left">{get_label('publish_date')}</td>
                <td class="left">
                    <input type="text" class="pgDate" name="publish_date" value="{set_value('publish_date',$general_info.publish_date|date_format:"%d-%m-%Y")}" />
                    <input type="text" class="pgTime" name="publish_time" value="{set_value('publish_time',$general_info.publish_date|date_format:"H:i")}" />
                </td>
            </tr>
            
            <tr>
                <td class="left">{get_label('counter_user_voting')}</td>
                <td class="left"><input type="text" name="counter_user_voting" value="{$general_info.counter_user_voting}" /></td>
            </tr>
            
            <tr>
                <td class="left">{get_label('counter_like')}</td>
                <td class="left"><input type="text" name="counter_like" value="{$general_info.counter_like}" /></td>
            </tr>
            
            <tr>
                <td class="left">{get_label('counter_comment')}</td>
                <td class="left"><input type="text" name="counter_comment" value="{$general_info.counter_comment}" /></td>
            </tr>
            
            <tr>
                <td class="left">{get_label('counter_view')}</td>
                <td class="left"><input type="text" name="counter_view" value="{$general_info.counter_view}" /></td>
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
            {$article = $articles[$lang.id]}
            <div id="tab-lang-{$lang.code}">
                <table class="list">
                    <tbody>            
                        
                        <tr>
                            <td class="left">{get_label('subject')}</td>
                            <td class="left"  style="width: 85%;"><input type="text" name="subject_{$lang.code}" value="{set_value('subject_'|cat:$lang.code, $article.subject)}" /></td>
                        </tr>                             
        
                        <tr>
                            <td class="left">{get_label('teaser')}</td>
                            <td class="left">
                               <textarea rows="5" cols="33" name="teaser_{$lang.code}">{set_value('teaser_'|cat:$lang.code, $article.teaser)}</textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="left">{get_label('content')}</td>
                            <td class="left"  style="height: 700px;">
                               <textarea rows="5" cols="33" name="content_{$lang.code}">{set_value('content_'|cat:$lang.code, $article.content)}</textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="left">{get_label('tags')}</td>
                            <td class="left"><input type="text" name="tags" value="{set_value('tags', $article.tags)}" /></td>
                        </tr>
        
                        <tr>
                            <td class="left">{get_label('slug')}</td>
                            <td class="left"><input type="text" name="slug" maxlength="255" value="{set_value('slug', $article.slug)}" form="FormAddUsers"/></td>
                        </tr>
        
                       <tr>
                            <td class="left">{get_label('seo_subject')}</td>
                            <td class="left"><input type="text" name="seo_subject_{$lang.code}" value="{$article.seo_subject}" /></td>
                       </tr>
                        
                        <tr>
                            <td class="left">{get_label('seo_description')}</td>
                            <td class="left">
                                <textarea rows="3" cols="150" name="seo_description_{$lang.code}">{$article.seo_description}</textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="left">{get_label('seo_keyword')}</td>
                            <td class="left"><input type="text" name="seo_keyword_{$lang.code}" value="{$article.seo_keyword}" /></td>
                        </tr>
                       
                        <tr>
                            <td class="left">{get_label('counter_user_voting')}</td>
			                <td class="left"><input type="text" name="counter_user_voting_{$lang.code}" value="{$article.counter_user_voting}" /></td>
			            </tr>
			            
			            <tr>
			                <td class="left">{get_label('counter_like')}</td>
			                <td class="left"><input type="text" name="counter_like_{$lang.code}" value="{$article.counter_like}" /></td>
			            </tr>
			            
			            <tr>
			                <td class="left">{get_label('counter_comment')}</td>
			                <td class="left"><input type="text" name="counter_comment_{$lang.code}" value="{$article.counter_comment}" /></td>
			            </tr>
			            
			            <tr>
			                <td class="left">{get_label('counter_view')}</td>
			                <td class="left"><input type="text" name="counter_view_{$lang.code}" value="{$article.counter_view}" /></td>
			            </tr>
                                 
                    </tbody>
                </table>
                <input type="hidden" name="article_dictionary_id_{$lang.code}" value="{$article.id}" />
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
             filebrowserImageBrowseUrl: '{base_url()}articles/admin_article_filemanager'
         });
    {/foreach}
});
</script>
