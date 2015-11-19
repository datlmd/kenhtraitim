<div class="category">
	<ul class="detail_list">
		<li><a href="{base_url()}">Trang chủ</a> ></li>
		<li>{$cate_name}</li>
	</ul><br/>
	{$i = 1}
	{foreach $films as $film}			
		<div class="col-md-2 category-item" title="{$film.name} - {$film.name_en} ({$film.year})">			
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
		{if $i == 14}
			<div class="clearfix"></div>
			<div class="adHome">
				<img class="img-responsive"  border="0" src="{static_frontend()}images/bn1.jpg" id="cpm9981">
			</div>
			<div class="clearfix"></div>
		{/if}
		{$i = $i +1}							
	{/foreach}  
	<div class="clearfix"></div>
	{$pagination_link}		
</div>
<div class="clearfix"></div>
<!---->