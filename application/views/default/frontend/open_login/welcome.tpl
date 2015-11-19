{include file=theme_web()|cat:'/frontend/open_login/header.tpl'}
<div id="container">
    <div class="welcome">Welcome: {$this->session->userdata('user_fullname')}<span> <a href="{if !$this->session->userdata('zing_logout')} {base_url('open_login/logout')} {else} {$this->session->userdata('zing_logout')} {/if}">Logout</a></span></div>
</div>
{include file=theme_web()|cat:'/frontend/open_login/footer.tpl'}