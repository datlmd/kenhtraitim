<div class="content">
	<div class=" content-top">
		<div class="number ">
			<ul class="detail_list">
				<li><a href="{base_url()}">Trang chủ</a> ></li>
				<li>{$category_url} ></li>
				<li><a href="{$url_cur}">{$film->name} - {$film->name_en} {$film->year}</a></li>
			</ul>
			<img class="img-responsive detail-img" src="{$film->image}" alt="{$film->name}">
			<h3 class="page-in">{$film->name} {$film->year}
				<span><b>Lượt xem:</b> {$film->counter_view} - <b>Ngày đăng:</b> {$film->created|date_format:"%d/%m/%Y"} - <b>Đóng góp:</b> {$film->username}</span>
			</h3>
			<h4 class="page-in">{$film->name_en}</h4>
			
			<div class="clearfix"></div>
			<div class="left-film">
				<div class="fb-google">				
				<!-- Place this tag in your head or just before your close body tag. -->
				<script src="https://apis.google.com/js/platform.js" async defer>
				  {
					  lang: 'vi'
				  }
				</script>			
				<!-- Place this tag where you want the +1 button to render. -->
				<div class="google" ><div class="g-plusone" data-annotation="none" data-size="medium" data-href="{$url_cur}"></div></div>
				<div class="fb-like" data-href="{$url_cur}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>
				<p class="title">Nội dung phim</p>
				<p class="page-top">{$film->description}</p><br/>
				<div class="left">
					<p class="title">Thể loại: <span>{$string_category}</span></p>
					<p class="title">Diễn viên: <span>{$film->actor}</span></p>					
					
					<p class="title">Đạo diễn: <span>{$film->director}</span></p>
				</div>
				<div class="right">
					<p class="title">Năm: <span>{$film->year}</span></p>					
					<p class="title">Quốc gia: <span>{$film->country}</span></p>					
					<p class="title">IMDB: <span>{$film->point_imdb}</span></p>					
				</div>
			</div>	
			<div class="left-film">
				<p class="title">Trailer</p>	
				<div class="js-video [vimeo, widescreen]">		 
					<iframe width="560" height="315" src="{str_replace('&controls=0','',$film->trailer)}" frameborder="0" allowfullscreen></iframe>
				</div>				
			</div>		
			<div class="clearfix"></div>
			<div class="link-download">
				{$film->link_download}
			</div>
			
			<div class="clearfix"></div>
			
			<div class="comment-top">
<!--				<div class="story">-->
<!--					<h4 class="stories "><span>Bình luận</span></h4>-->
<!--				</div>-->
				<!---->
				
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3&appId=1641296099425791";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-comments" data-href="{$url_cur}" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			<!---->
			</div>

		</div>
	</div>
	<!---->
	{if $film_tag}
			<div class="clearfix"></div>	
			<div class="cinema cinema_home">		
				<h1>Phim liên quan</h1>
				<div class="cinema-top">
					{foreach $film_tag as $film}			
						<div  class="col-md-2 top-cinema" title="{$film.name} - {$film.name_en} ({$film.year})">			
							<a href="{base_url()}phim-{$film.slug}-{$film.id}.html"><img class="img-responsive" src="{$film.image_small}" width="100%" alt="{$film.name} - {$film.name_en} - kenhtraitim.com">
								<span class="labelchap2">{$film.quality} | {$film.subtitle}</span>
							</a>									
							<div class="caption">							
								<h3 class="cinema">	
									<a href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name} ({$film.year})</a><br />
									<a class="title_en" href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name_en}</a>
								</h3>	
							</div>									
						</div>							
					{/foreach}  
				</div>
			</div>
			{/if}
	{if $film_cate}
	<div class="clearfix"></div>	
	<div class="cinema cinema_home">		
		<h1>Phim cùng thể loại</h1>
		<div class="cinema-top">
			{foreach $film_cate as $film}			
				<div  class="col-md-2 top-cinema" title="{$film.name} - {$film.name_en} ({$film.year})">			
					<a href="{base_url()}phim-{$film.slug}-{$film.id}.html"><img class="img-responsive" src="{$film.image_small}" width="100%" alt="{$film.name} - {$film.name_en} - kenhtraitim.com">
						<span class="labelchap2">{$film.quality} | {$film.subtitle}</span>
					</a>									
					<div class="caption">							
						<h3 class="cinema">	
							<a href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name} ({$film.year})</a><br />
							<a class="title_en" href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name_en}</a>
						</h3>	
					</div>									
				</div>							
			{/foreach}  
		</div>
	</div>
	{/if}
	{if $film_view}
	<div class="clearfix"></div>	
	<div class="cinema cinema_home">		
		<h1>Phim xem nhiều nhất</h1>
		<div class="cinema-top">
			{foreach $film_view as $film}			
				<div  class="col-md-2 top-cinema" title="{$film.name} - {$film.name_en} ({$film.year})">			
					<a href="{base_url()}phim-{$film.slug}-{$film.id}.html"><img class="img-responsive" src="{$film.image_small}" width="100%" alt="{$film.name} - {$film.name_en} - kenhtraitim.com">
						<span class="labelchap2">{$film.quality} | {$film.subtitle}</span>
					</a>									
					<div class="caption">							
						<h3 class="cinema">	
							<a href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name} ({$film.year})</a><br />
							<a class="title_en" href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name_en}</a>
						</h3>	
					</div>									
				</div>							
			{/foreach}  
		</div>
	</div>
	{/if}
	<div class="clearfix"></div>
</div>