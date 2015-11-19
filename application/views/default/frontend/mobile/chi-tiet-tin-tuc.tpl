<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_news">
                <div class="title number">
                    <figure><span>Tin tức</span></figure>
                </div>
                <div class="section group">
                    {if isset($content.0)}
                        <div class="article-header">
                            {if isset($detail.0)}
                                <div class="article-image">
                                    <img src="{media_url()}images/{$detail.0.thumbnail_image}"/>
                                </div>
                                <div class="article-info">
                                    <div class="article-title">
                                        {$content.0.subject}
                                    </div>
                                    <div class="date">
                                        {$detail.0.modified}
                                    </div>
                                    <div class="rate">
                                        <p>{$detail.0.counter_view+1} View</p>
                                    </div>
                                </div>
                            {/if}
                        </div>
                        <div style="clear: both;"></div>
                        <div class="article-content">
                            {$content.0.content}
                        </div>
                    {else}
                        <center><h1>Thông tin không tồn tại!</h1></center>
                        {/if}
                </div>
            </div>
        </div>
    </div> 
</div>