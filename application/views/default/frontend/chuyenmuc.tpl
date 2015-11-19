<span style="font-size: 11px;">Nội dung tin tức được Robot quét tự động trực tuyến không lưu dữ liệu với thao tác của người dùng từ các nguồn RSS trên mạng, chúng tôi không chịu trách nhiệm liên quan đến nội dung, chúng tôi sẽ loại bỏ toàn bộ các nội dụng không phù hợp với pháp luật của Việt Nam</span>
<div class="cate_news">
	Bạn muốn quét tin tức từ:	
        <a href="type?type=1"><img src="{static_frontend()}images/kenh14.png" alt=""></a>
	<img src="{static_frontend()}images/vnexpress.png" alt="">
	<img src="{static_frontend()}images/logo_NS.png" alt="">
	<img src="{static_frontend()}images/logo_zing_trithuc.png" alt="">
        <a href="type?type=4"><img src="{static_frontend()}images/logo2saohd2.png" alt=""></a>
	<img src="{static_frontend()}images/ngoisaovn.png" alt="">
	<img src="{static_frontend()}images/dantri.png" alt="">
	<img src="{static_frontend()}images/tuoitre.png" alt="">
	<img src="{static_frontend()}images/phapluat.png" alt="">
</div>
<div class="grid-top-in">
	{$a = array('jol','lop','bun','live','dan','eva')}
	<p>
	{foreach $list_url as $url}
		<a href="{base_url()}chuyenmuc?url={$url.url}" class="{$a[array_rand($a,1)]}">{$url.name}</a>
	{/foreach}	
	</p>									 	
</div><br/>
<div class="clearfix"></div>
<div class="magazine">	
	<div class="magazine-top">
	{$i = 1}
		{foreach $list_all as $article}
			{if $i < 3}
			<div class="col-md-3">
				<a href="{base_url()}chitiet?url={$article.href}" title="{$article.title}"><img class="img-responsive chain" width="357" src="{$article.img}" alt="{$article.title}">					
				</a>
				<div class="magazine-grid">
					<h3><a href="{base_url()}chitiet?url={$article.href}">{$article.title}</a></h3>
					<span class="date_n"><a href="{$article.url_cate}">{$article.cate}</a> | {$article.date} (Nguồn: <b>{$article.domain}</b>)</span>
					<p>{$article.note}</p>					
				</div>
			</div>
			{else}
				<div class="news-list">
					<a href="{base_url()}chitiet?url={$article.href}"><img class="img-responsive chain" width="357" src="{$article.img}" alt="{$article.title}">	
					{$article.title}</a><br/>
					<span class="date_n"><a href="{$article.url_cate}">{$article.cate}</a> | {$article.date} (Nguồn: <b>{$article.domain}</b>)</span>
				</div>
			{/if}
			{if $i == 7}
				<div class="clearfix"></div>
				</div>
				<div class="magazine-top">
				{$i = 0}
			{/if}
			{$i = $i + 1}
		{/foreach}			
		<div class="clearfix"></div>
	</div>
	
</div>
<div class="clearfix"></div>
{$page}