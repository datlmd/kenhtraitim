<link href="{base_url()}static/basic_view/css/style.css" type="text/css" rel="stylesheet" />
<div class="basic_list">
    {foreach $list_views as $list_view}
        <div class="prod_box">
            <div class="content_box">
                {foreach from=$list_view key=field item=field_type name=field_name}
                    {if is_image_link($list_view.$field)}
                        <div class='basic_{$field}'><a title="{img_url()}media/images/{$list_view.$field}" href="{img_url()}media/images/{$list_view.$field}"><img height="90" src="{img_url()}media/images/{$list_view.$field}" /></a></div>
                        {else}
                        <div class='basic_{$field}'>
                            {$value = pg_field_value($list_view.$field, $field_type)}
                                {$value}
                        </div>
                    {/if}
                {/foreach}
                <br />
                <a href="{$detail_common_link}{$list_view.id}">Link detail</a>
            </div>
        </div>
    {/foreach}
    <!-- end of center content -->
    <div style="clear:both;height:1%"></div>
</div>
<!-- end of main content -->