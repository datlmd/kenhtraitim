<?php $this->load->view("default/open_login/header");?>
<?php
	$zingLogout = $this->session->userdata('zing_logout');
?>
<div id="container">
	<div class="welcome">Welcome: <?php print $this->session->userdata('user_fullname'); ?><span> <?php print anchor($zingLogout == "" ? "open_login/logout": $zingLogout, "Logout"); ?></span></div>
</div>
<?php $this->load->view("default/open_login/footer");?>