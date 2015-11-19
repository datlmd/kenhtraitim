<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_news">
                <div class="title number">
                    <figure><span>Tin tức</span></figure>
                </div>
                <div class="section group">
                    <div class="pagination-style">{$pagination_link}</div>
                    <ul class="list-news">
                        {foreach from=$list_articles item=article}
                            <li>
                                <div class="article-thumb"><a href="{base_url()}mobile/chi_tiet_tin_tuc/{$article.article_id}" title=""><img style="height: 100%; margin: auto" src="{media_url()}images/{$article.thumbnail_image}" alt=""></a></div>
                                <h3><a href="{base_url()}mobile/chi_tiet_tin_tuc/{$article.article_id}" title="">{$article.subject}</a></h3>
                                <p class="date">{$article.modified}</p>
                                <div class="tearser">{$article.teaser}</div>
                                <a style="position: absolute; right: 0; bottom: 0; font-size: 12px; color: darkblue" href="{base_url()}mobile/chi_tiet_tin_tuc/{$article.article_id}">Chi tiết</a>
                            </li>
                        {/foreach}
                    </ul>
                    <div class="pagination-style">{$pagination_link}</div>
                </div>
            </div>
        </div>
    </div> 
</div>