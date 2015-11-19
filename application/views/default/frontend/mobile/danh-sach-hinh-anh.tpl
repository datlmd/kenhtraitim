<script type="text/javascript">
    $(document).ready(function() {
        $(".images-container").click(function() {
            var content = $(this).find(".images-info").html();
            $(".fancybox").fancybox({
                helpers: {
                    title: {
                        type: 'inside'
                    }
                },
                title: content
            });
        });
    });
</script>
<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_news">
                <div class="title number">
                    <figure><span>Hình ảnh</span></figure>
                </div> 
                <div class="section group">
                    <div class="pagination-style">{$pagination_link}</div>
                    {foreach from=$list_photos item=photo}
                        <div class="images-container">
                            <a class="fancybox" {*data-fancybox-group="gallery"*} href="{media_url()}images/{$photo.image_name}" title="">
                                <img src="{media_url()}images/{get_image_thumb($photo.image_name,'crop_crop')}" alt="">
                                <div class="images-info">
                                    <a style="" href="#">{$photo.username}</a>
                                    <p style="">{$photo.name}</p>
                                    <p style="font-style: italic; font-size: 12px;">{$photo.created}</p>
                                    <a style="font-style: italic; float: right;" href="{base_url()}mobile/chi_tiet_hinh_anh/{$photo.id}">Chi tiết hình ảnh</a>
                                    <br/>
                                </div>
                            </a>

                        </div>
                    {/foreach}
                    <div class="pagination-style">{$pagination_link}</div>
                </div>
            </div>
        </div>
    </div> 
</div>