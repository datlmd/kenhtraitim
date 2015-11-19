<div class="gallery">
	<!-- requried-jsfiles-for owl -->
	<link href="{static_frontend()}css/owl.carousel.css" rel="stylesheet">
	<script src="{static_frontend()}js/owl.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$("#owl-demo").owlCarousel({
				singleItem:true,
				lazyLoad : true,
				autoPlay : true,
				pagination : true,
				navigation : true,
				navigationText :  true,			     
			});
//
//			$(".cinema_home #slide_cate").owlCarousel({
//				//items : 1,
//				lazyLoad : true,
//				autoPlay : false,
//				pagination : false,
//				navigation : false,
//				navigationText :  false,		     
//			});
		});
	</script>
	<!-- //requried-jsfiles-for owl -->
	<!-- start content_slider -->
	<div id="owl-demo" class="owl-carousel">
	{foreach $film_focus as $film}
		<div class="item g1" title="{$film.name} - {$film.name_en} ({$film.year})">
			<a href="{base_url()}phim-{$film.slug}-{$film.id}.html"><img class="lazyOwl" data-src="{$film.image}" alt="{$film.name} - {$film.name_en} - kenhtraitim.com"></a>
			<h3 class="cinema-focus">	
				<a href="{base_url()}phim-{$film.slug}-{$film.id}.html">{$film.name} - {$film.name_en} ({$film.year})</a><br />
			</h3>				
		</div>
	{/foreach}
	</div>
	<!--//sreen-gallery-cursual---->
</div>
			

				<!-- main -->
<div class="content">
	<div class="cinema cinema_home">
		<h1>Phim HOT</h1>
		<div class="cinema-top">
			{foreach $film_hot as $film}			
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
	<div class="clearfix"></div>
	<div class="adHome">
		<img class="img-responsive"  border="0" src="{static_frontend()}images/bn1.jpg" id="cpm9981">
	</div>
	<div class="clearfix"></div>
	
	<div class="cinema cinema_home">		
		<h1>Phim lẻ mới cập nhật</h1>
		<div class="cinema-top">
			{foreach $film_le as $film}			
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
	<div class="clearfix"></div>
	<div class="adHome">
<!--		<img class="img-responsive"  width="980" height="90" border="0" src="//adi.vcmedia.vn/adt/adn/2014/12/980x9-ad11417509878.jpg" id="cpm9981">-->
	</div>
	<div class="clearfix"></div>	
	<div class="cinema cinema_home">
		<h1>Phim bộ mới cập nhật</h1>
		<div class="cinema-top">
			{foreach $film_bo as $film}			
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
	<div class="clearfix"></div>
	<div class="adHome">
		<img class="img-responsive" border="0" src="{static_frontend()}images/bn2.jpg" id="cpm9981">
	</div>
	<div class="clearfix"></div>
</div>