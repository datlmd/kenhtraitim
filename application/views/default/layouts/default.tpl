<!DOCTYPE html>
<head>        
    {include file=theme_web()|cat:'/layouts/_head.inc.tpl'}
</head>

<body>
    <!--header-->
	<div class="back">
		<img src="{static_frontend()}images/back.png" alt="">
	</div>	
	<div class="container">
		<div class="main-top">
			<div class="main">
				<div class="header">
					<div class="header-top">
						<div class="header-in">
							<div class="logo">
								<a href="{base_url()}"><img src="{static_frontend()}images/logo.png" alt="" ></a>
							</div>
							<div class="search">
								<form>
									<input type="text" value="" >
									<input type="submit" value="SEARCH">
								</form>
							</div>
							<div class="clearfix"> </div>
						</div>
<!--						<div class="header-top-on">-->
<!--							<ul class="social-in">-->
<!--								<li><a href="#"><i> </i></a></li>						-->
<!--								<li><a href="#"><i class="facebook"> </i></a></li>-->
<!--								<li><a href="#"><i class="tin"> </i></a></li>-->
<!--							</ul>-->
<!--						</div>-->
						<div class="clearfix"> </div>
					</div>
					<!---->
					<div class="header-bottom">
						<div class="navigation">	
							<div>
							  <label class="mobile_menu" for="mobile_menu">
							  <span>Menu</span>
							  </label>
							  <input id="mobile_menu" type="checkbox">
								<ul class="nav">
									<li><a class="color1" href="{base_url()}">Trang chủ</a></li>                  
									<li><a href="{base_url()}phim-le.html" class="color2">Phim lẻ</a>
										<ul>
										{foreach $cate_le as $cate}	
											<li><a href="{base_url()}{$cate.slug}.html">{$cate.name}</a></li>
										{/foreach}
										</ul>
									</li>            
									<li><a href="{base_url()}phim-bo.html" class="color3">phim bộ</a>
										<ul>
										{foreach $cate_bo as $cate}	
											<li><a href="{base_url()}{$cate.slug}.html">{$cate.name}</a></li>
										{/foreach}
										</ul>
									</li>						  
									<li class="dropdown"><a href="{base_url()}phim-3d.html" class="color4">Phim 3D<span> </span></a></li>  
									<li><a href="{base_url()}tintuc" class="color5">Tin tức</a></li>
<!--									<li><a href="contact.html" class="color6">Liên hệ</a></li>-->
									<div class="clearfix"></div>
								</ul>
							</div>			
						</div>
					</div>
				</div>
				{$MainContent}
				
			</div>
			<i class="line"> </i>
			<i class="line-in"> </i>
			<i class="line-in line-in1"> </i>
			<i class="line-in line-in2"> </i>
		</div>
		<p class="footer-class">Copyright © 2015 kenhtraitim.com<br/>
			 <span style="font-size: 10px;">Phim được tổng hợp từ các nguồn trên mạng, chúng tôi không chịu trách nhiệm liên quan đến nội dung, chúng tôi sẽ loại bỏ toàn bộ các nội dụng không phù hợp với pháp luật của Việt Nam</span>
		</p>
		<script type="text/javascript">
							$(document).ready(function() {
								/*
								var defaults = {
						  			containerID: 'toTop', // fading element id
									containerHoverID: 'toTopHover', // fading element hover id
									scrollSpeed: 1200,
									easingType: 'linear' 
						 		};
								*/
								
								$().UItoTop({ easingType: 'easeOutQuart' });
								
							});
						</script>
					<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	
	
	</div>
    
    <!--------------------CORE FOOTER - NO DELETE----------------------------------------->
    {if is_access('admin_users', 'r')}
        <div style="display:inline-block;position:fixed;right:5px;bottom:0;padding:5px 10px;background:#333333;font-weight:700;z-index:9999">
            <a href="{base_url('users/admin_users/dashboard')}" style="">{lang('Admin')}</a> |
            <a href="{base_url('users/logout')}" style="">{lang('Logout')}</a>
        </div>
    {/if}

<!--------------------END CORE FOOTER - NO DELETE----------------------------------------->
{literal}
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61959385-1', 'auto');
  ga('send', 'pageview');

</script>
{/literal}
</body>
</html>