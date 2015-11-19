<?php $this->load->view("default/open_login/header");?>
<?php $imgZing = array(
          'src' => 'static/default/frontend/images/logo_zingid.png',
          'alt' => 'Login with Zing ID',
          'title' => 'Login with Zing ID',
	  );
	  $imgGoogle = array(
          'src' => 'static/default/frontend/images/goog-login-button.png',
          'alt' => 'Login with Google Account',
          'title' => 'Login with Google Account',
	  );
	  $imgFacebook = array(
          'src' => 'static/default/frontend/images/fb-login-button.png',
          'alt' => 'Login with Facebook Account',
          'title' => 'Login with Facebook Account',
	  );
	  $imgYahoo = array(
          'src' => 'static/default/frontend/images/yahoo-oauth-connect.png',
          'alt' => 'Login with Yahoo Account',
          'title' => 'Login with Yahoo Account',
	  );
?>
	
<div id="container">
	<div class=""><a href="#" id="login-popup">Login</a></div>
	<div id="dialog" title="Login with social account">
	<h2>Login with social account</h2>
	<form name="frm-login" action="http://sso2.zing.vn/index.php?method=login" method="post">
	<input type="hidden" name="u1" value="http://demoproduct.ad.zing.vn/open_login/zing" />
	<input type="hidden" name="fp" value="http://demoproduct.ad.zing.vn/open_login/zing_fail" />
	<input type="hidden" name="pid" value="69" />
	<div class="form-item"><label>Zing ID: </label><input type="text" class="textfield" name="u" id="txt-username" /></div>
	<div class="form-item"><label>Password: </label><input type="password" class="textfield" name="p" id="txt-password" /></div>
	<div class="form-submit"><input type="submit" value="Login" /></div>
	</form>
	<div class="social-login-list">
	<span><?php print anchor($ggURL, img($imgGoogle)); ?></span>
	<span><?php print anchor($fbURL, img($imgFacebook)); ?></span>
	<span><?php print anchor($yhURL, img($imgYahoo)); ?></span>
	</div>
	</div>
</div>
 <script>
	$(function() {
	$( "#dialog" ).dialog({
	autoOpen: false,
	show: {
	effect: "blind",
	duration: 200
	},
	hide: {
	effect: "blind",
	duration: 200
	}
	});
	$( "#login-popup" ).click(function() {
	$( "#dialog" ).dialog( "open" );
	});
	});
</script>
<?php $this->load->view("default/open_login/footer");?>