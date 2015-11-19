<span style="font-size: 11px;">Nội dung tin tức được Robot quét tự động trực tuyến không lưu dữ liệu với thao tác của người dùng từ các nguồn RSS trên mạng, chúng tôi không chịu trách nhiệm liên quan đến nội dung, chúng tôi sẽ loại bỏ toàn bộ các nội dụng không phù hợp với pháp luật của Việt Nam</span>

<div class="grid-top-in">
	{$a = array('jol','lop','bun','live','dan','eva')}
	<p>
	{foreach $list_url as $url}
		<a href="{base_url()}chuyenmuc?url={$url.url}" class="{$a[array_rand($a,1)]}">{$url.name}</a>
	{/foreach}	
	</p>									 	
</div><br/><br/>
<!---->
<div class="content" id="content">
	<div class="col-md-8 content-top">
		<div class="content-news">
			<h3>{$title}</h3>	
			<span class="date">{$date_n|date_format:"%d/%m/%Y %I:%M %p"} - <b>Nguồn:</b> <a title="{$url_root}" target="_blank" href="{$url_root}">{substr($url_root,0,30)}...</a></span>					
			<p class="des">{$tomtat}</p>
			<div class="news-tag simply">
				{$tags}
			</div>	
			{$content}
    	</div>
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
		<!---->
		<div class="simply">
			<div class="story">
				<h4 class="stories stories-in"><span>Tin cùng chuyên mục</span></h4>
			</div>
			{$tags}				
			<div class="clearfix"></div>
		</div>		
	</div>
	<!---->
		<div class="col-md-4 sin-bottom">
			
			<div class="might">
				<h4>Tiêu điểm</h4>
				<div class="news-focus">{$focus}</div>
			</div>
			<div class="clearfix"></div>
			<!---->
<!--			<div class="grid-top">-->
<!--				<h4>Archives</h4>-->
<!--				<ul>-->
<!--					<li><a href="#">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </a></li>-->
<!--					<li><a href="#">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</a></li>-->
<!--					<li><a href="#">When an unknown printer took a galley of type and scrambled it to make a type specimen book. </a> </li>-->
<!--					<li><a href="#">It has survived not only five centuries, but also the leap into electronic typesetting</a> </li>-->
<!--					<li><a href="#">Remaining essentially unchanged. It was popularised in the 1960s with the release of </a> </li>-->
<!--					<li><a href="#">Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing </a> </li>-->
<!--					<li><a href="#">Software like Aldus PageMaker including versionsof Lorem Ipsum.</a> </li>-->
<!--				</ul>-->
<!--			</div>-->
			
			
		</div>
		<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div class="cate_news">
	Bạn muốn quét tin tức từ:	
	<img src="{static_frontend()}images/kenh14.png" alt="">
	<img src="{static_frontend()}images/vnexpress.png" alt="">
	<img src="{static_frontend()}images/logo_NS.png" alt="">
	<img src="{static_frontend()}images/logo_zing_trithuc.png" alt="">
	<img src="{static_frontend()}images/logo2saohd2.png" alt="">
	<img src="{static_frontend()}images/ngoisaovn.png" alt="">
	<img src="{static_frontend()}images/dantri.png" alt="">
	<img src="{static_frontend()}images/tuoitre.png" alt="">
	<img src="{static_frontend()}images/phapluat.png" alt="">
</div>