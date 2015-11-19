<title>{$MainTitle}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{$MainKeyword}" />
<meta name="description" content="{$MainDescription}" />
<meta name="robots" content="index, follow" />
<meta name="revisit-after" content="7 days" />
<meta name="author" content="Kênh Trái Tim" />
<meta name="copyright" content="2015 kenhtraitim.com" />

<meta property="fb:admins" content="kenhtraitim.com">
<meta property="og:country-name" content="Vietnam" />
<meta property="og:type" content="Article" />
<meta property="og:title" content="{$MainTitle}" />
<meta property="og:description" content="{$MainDescription}" />
<meta property="og:image" content="{$MainImage}"/>
<meta name="dcterms.description" content="{$MainDescription}" />

<meta name="revisit-after" content="1 day" />

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<!--CORE CSS JS-->
<link rel="shortcut icon" href="{static_frontend()}images/favicon.ico" type="image/x-icon" />

<link href="{static_frontend()}css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="{static_frontend()}css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="{static_frontend()}css/nav.css" rel="stylesheet" type="text/css" media="all"/>

<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
<!--//fonts-->

{if $pgRel}{$pgRel}{/if}
<script src="{static_frontend()}js/jquery.min.js"></script>
<script type="application/x-javascript">
	addEventListener("load", function() { 
		setTimeout(hideURLbar, 0); 
	}, false); function hideURLbar(){ 
		window.scrollTo(0,1); 
	} 
</script>
<script type="text/javascript" src="{static_frontend()}js/move-top.js"></script>
<script type="text/javascript" src="{static_frontend()}js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({
				scrollTop:$(this.hash).offset().top
				},1000);
		});
	});
</script>
<script src="{static_frontend()}js/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#horizontalTab,#horizontalTab1,#horizontalTab2').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true   // 100% fit in a container
		});
	});
</script>


<script src="{static_frontend()}js/main.js"></script> <!-- Resource jQuery -->