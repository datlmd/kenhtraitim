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
</div>
<div style="clear:both;height:1%"></div>
<!-- end of main content -->
<div id="basic_pagging">
    <div style="width:100%; float:right">
        <script type="text/javascript">
            $("#basic_pagging").paginate({
                count 		:  '{$total_page_button}',
                start 		: '{$current_page}',
                display     : 10,
                border					: true,
                border_color			: '#BEF8B8',
                text_color  			: '#68BA64',
                background_color    	: '#E3F2E1',
                border_hover_color		: '#68BA64',
                text_hover_color  		: 'black',
                background_hover_color	: '#CAE6C6',
                rotate      : false,
                images		: false,
                mouse		: 'press',
                onChange: function (page) { PagingAction(page, 10);$(".fancybox").fancybox();}
            });
        </script>
    </div>
</div>