{*

/**
 * PENGUIN FrameWork
 * @author tungcn <cntung2187@gmail.com> 0909898592
 * @copyright Chung Nhut Tung 2011
 * 
 * View Category
 * 
 * @package PenguinFW
 * @subpackage articles
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Article Category info')}: {$article_category->name}</h1>
    
    <div class=buttons>                
        <a href="{base_url()}articles/admin_article_categories/edit/{$article_category->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>
<div class="content">
    <table class="list">
        <tbody>
            <tr>
                <td class="left head">{get_label('category_status_id')}</td>
                <td class="left">{$article_category->category_status_name}</td>
            </tr>            
            <tr>
                <td class="left head">{get_label('name')}</td>
                <td class="left">{$article_category->name}</td>
            </tr>            
            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{$article_category->description}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{$article_category->slug}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('parent_id')}</td>
                <td class="left">{$article_category->parent_name}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('article_counter')}</td>
                <td class="left">{$article_category->article_counter}</td>
            </tr>
            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{$article_category->weight}</td>
            </tr>
        </tbody>
    </table>
</div>