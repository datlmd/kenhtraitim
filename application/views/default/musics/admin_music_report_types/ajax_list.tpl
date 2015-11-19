{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST Musics report type
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}
<table class="list">
    <thead>
        <tr><td class="left">{lang('Name')}</td></tr>
    </thead>
    
    <tbody>        
        {$category_html = '<tr><td class="left"><a href="javascript:loadAjax(\'##HREF##/##VALUE##\');">##INDENT_SYMBOL####NAME##</a></td></tr>'}
        {$indent_symbol = '-&nbsp;'}
        {draw_tree_category_block($report_types, $category_html, 0, $indent_symbol, array(), $href_link)}
    </tbody>
</table>