<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_news">
                <div class="title number">
                    <figure><span>Videos & Musics</span></figure>
                </div> 
                <div class="section group">
                    <div class="pagination-style">{$pagination_link}</div>
                    {foreach from=$list_media item=media}
                        <div class="video-container images-container">
                            <a href="{base_url()}mobile/chi_tiet_video/{$media.id}" title="">
                                <img src="{media_url()}images/{$media.avatar}" alt="">
                                <img id="play-icon" src="{static_base()}mobile/images/playicon.png" style="position: absolute; top: 40%; left: 40%; width: 20%; height: auto; opacity: 0.8;" />
                            </a>

                            <div class="images-info">
                                <a style="" href="#">{$media.username}</a>
                                <p style="">{$media.name}</p>
                                <p style="font-style: italic; font-size: 12px;">{$media.created}</p>
                                <a style="font-style: italic; float: right;" href="{base_url()}mobile/chi_tiet_video/{$media.id}">Chi tiết</a>
                                <br/>
                            </div>
                        </div>
                    {/foreach}
                    <div class="pagination-style">{$pagination_link}</div>
                </div>
            </div>
        </div>
    </div> 
</div>