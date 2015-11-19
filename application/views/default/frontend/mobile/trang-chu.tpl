<script type="text/javascript">
    $(document).ready(function() {
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
</script>
<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_rule">
                {if isset($thele.0)}
                    <div class="title number">
                        <figure><span>Thể lệ</span></figure>
                    </div>
                    <div class="section group">
                        <div class="col span">
                            <div class="num-heading">
                                <div class="title number">
                                    <figure><span>*</span></figure>
                                </div>
                                <div class="heading">								
                                    <h4>{$thele.0.subject}</h4>
                                </div>
                                <div class="clear"></div>
                            </div> 
                            <div class="heading-desc">	
                                <p>{$thele.0.teaser}</p>
                                <a href="{base_url()}mobile/the-le" class="button">Chi Tiết</a>
                            </div>	
                        </div>
                    </div>
                {/if}
            </div>

            <div class="wrapper content_news">
                <div class="title number">
                    <a href="{base_url()}mobile/tin-tuc/1"><figure><span>Tin tức</span></figure></a>
                </div>
                <div class="section group">
                    {assign var="number_article" value=1}
                    {foreach from=$articles item=article}
                        {if isset($article.id)}
                            <div class="col span">
                                <div class="num-heading">
                                    <div class="title number">
                                        <figure><span>{$number_article}</span></figure>
                                    </div>
                                    <div class="heading">								
                                        <a href="{base_url()}mobile/chi_tiet_tin_tuc/{$article.id}"><h4>{$article.subject}</h4></a>
                                    </div>
                                    <div class="clear"></div>
                                </div> 
                                <div class="heading-desc">	
                                    <center>
                                        <a href="{base_url()}mobile/chi_tiet_tin_tuc/{$article.id}">
                                            <img src="{media_url()}images/{$article.thumbnail_image}" alt="">
                                        </a>
                                    </center>
                                    <p>{$article.teaser}</p>
                                    <a href="{base_url()}mobile/chi_tiet_tin_tuc/{$article.id}" class="button">Chi tiết</a>
                                </div>	
                            </div>
                        {/if}
                        {assign var=number_article value=$number_article+1}
                    {/foreach}
                </div>
            </div>

            <div class="wrapper content_media">
                <div class="title number">
                    <a href="{base_url()}mobile/hinh-anh/0"><figure><span><h5>Hình ảnh</h5></span></figure></a>
                </div>
                <div class="section group" style="text-align: center;">
                    <div class="images">
                        {foreach from=$photos item=photo}
                            {if isset($photo.id)}
                                <div class="images-container">
                                    <a class="fancybox" {*data-fancybox-group="gallery"*} href="{media_url()}images/{$photo.image_name}"><img src="{media_url()}images/{get_image_thumb($photo.image_name,'crop_crop')}" alt=""></a>
                                    <div class="images-info">
                                        <a style="" href="#">{$photo.username}</a>
                                        <p style="">{$photo.name}</p>
                                        <p style="font-style: italic; font-size: 12px;">{$photo.created}</p>
                                        <a style="font-style: italic; float: right;" href="{base_url()}mobile/chi_tiet_hinh_anh/{$photo.id}">Chi tiết hình ảnh</a>
                                        <br/>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>