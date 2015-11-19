<div id="content">
    <div class="row">
        <div class="left-content">
            <div class="feature-news"> 
                <h2 class="ui-text ui-text-12">Tin nóng</h2>
                <div class="outer">
                    <div id="lofslidecontent" class="lof-slidecontent">
                        <div class="lof-main-outer">
                        <ul class="lof-main-wapper">
                        	{$i=0} 
					        {foreach $list_articles as $article}
                                {if $i < 5}
                                    <li class="lof-main-item">
                                        <img src="{img_url()}/media/images/{$article.thumbnail_image}"  alt="" />
                                        <div class="lof-main-item-desc">
                                            <h4><a href="{get_link('articles', '', 'news_detail', $article.id|cat:'/'|cat:$article.slug)}" title="{$article.subject}">{$article.subject}</a><span class="date">({$article.publish_date|date_format:"%d/%m/%Y"})</span></h4>
                                        </div>
                                    </li>
                                {/if}
                                {if $i == 5}
                                    {break}
                                {/if}
                                {$i = $i+1}
                            {/foreach}
                        </ul>
                        </div>
                        <div class="lof-navigator-outer">
                        <ul class="lof-navigator">
                        	{$i=0} 
					        {foreach $list_articles as $article}
						        {if $i < 5}
						        {$image_thumb = get_image_thumb($article.thumbnail_image, 'small_thumb')}	                           
	                            <li>
	                                <div>
	                                    <img src="{img_url()}media/images/{$image_thumb}" width="80" height="50" alt="" />
	                                    <h4>{$article.subject}</h4>
	                                    <p class="date">({$article.publish_date|date_format:"%d/%m/%Y"})</p>
	                                </div>    
	                            </li>
                            	{/if}
                            	{if $i == 5}
                            		{break}
                            	{/if}
								{$i = $i+1}
					        {/foreach}                             	
                        </ul>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="list-news">
                <ul class="list">
                	{$i=0} 
					{foreach $list_articles as $article}
					     {if $i >= 5}
					     {$image_thumb = get_image_thumb($article.thumbnail_image, 'small_thumb')}
						     {if $i%2 == 0}
						     <li class="odd">
						     {else}
						     <li class="even">
						     {/if}
		                        <div class="desc">
		                            <h4><a href="{get_link('articles', '', 'news_detail', $article.id|cat:'/'|cat:$article.slug)}" title="{$article.subject}">{$article.subject}</a></h4>
<!--		                            <p class="short-content">{$article.teaser}</p>-->
		                            <p class="date">({$article.publish_date|date_format:"%d/%m/%Y"})</p>
		                        </div>
		                        <span class="thumb"><img src="{img_url()}media/images/{$image_thumb}" alt="" /></span>
		                    </li>	                            
                        {/if}
						{$i = $i+1}
					{/foreach}                     
                </ul>
                <div class="paging-bar">
<!--                    <span class="total">Trang 1 / 120</span>-->
                    {$pagination_link}
<!--                    <ul class="nav">-->
<!--                        <li><a href="#" title="Trang đầu">Trang đầu</a> &nbsp;|</li>-->
<!--                        <li> -->
<!--                            <ul>-->
<!--                                <li><a class="active" href="#" title="1">1</a></li> -->
<!--                                <li><a href="#" title="1">2</a></li> -->
<!--                                <li><a href="#" title="1">3</a></li> -->
<!--                                <li><a href="#" title="1">4</a></li>-->
<!--                            </ul>-->
<!--                        </li> -->
<!--                        <li>| &nbsp;<a href="#" title="Trang kế">Trang kế</a> &nbsp;|</li> -->
<!--                        <li><a href="#" title="Trang cuối">Trang cuối</a></li>-->
<!--                    </ul>-->
                </div>
            </div>					
        </div>
        <div class="right-content">
            <div class="list-schedule">
                <h2 class="ui-text ui-text-13">Ngày thử giọng</h2>
                <ul>
                    <li>
                        <p class="date">17/08/2012</p>
                        <p class="name">Audition Hà Nội</p>
                        <p>Phát sóng vào 20h00 trên kênh VTV3</p>
                    </li>
                    <li>
                        <p class="date">24/08/2012</p>
                        <p class="name">Audition Đà Nẵng</p>
                        <p>Phát sóng vào 20h00 trên kênh VTV3</p>
                    </li>
                    <li>
                        <p class="date">31/08/2012</p>
                        <p class="name">Audition Hồ Chí Minh</p>
                        <p>Phát sóng vào 20h00 trên kênh VTV3</p>
                    </li>
                    <li>
                        <p class="date">07/09/2012</p>
                        <p class="name">Theater</p>
                        <p>Phát sóng vào 20h00 trên kênh VTV3</p>
                    </li>
                </ul>
            </div>
            <div class="adv">
                <div class="item">
                	<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="300" height="250">
        	    <param name="movie" value="{static_url()}static/default/frontend/swf/RightB1.swf" />
        	    <param name="quality" value="high" />
        	    <param name="wmode" value="transparent" />
        		<param name="swfversion" value="6.0.65.0" />        		
        	    <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->        	    
        	    <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
        	    <!--[if !IE]>-->
        	    <object type="application/x-shockwave-flash" data="{static_url()}static/default/frontend/swf/RightB1.swf" width="300" height="250">
        	      <!--<![endif]-->
        	      <param name="quality" value="high" />
        	      <param name="wmode" value="transparent" />        	      
        		<param name="swfversion" value="6.0.65.0" />        	      
        	      <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
        	      <div>
        	        <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
        	        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
      	        </div>
        	      <!--[if !IE]>-->
      	      </object>
        	    <!--<![endif]-->
      	    </object>
                </div>
                <div class="item">
					<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="300" height="250">
        	    <param name="movie" value="{static_url()}static/default/frontend/swf/giai_thuong.swf" />
        	    <param name="quality" value="high" />
        	    <param name="wmode" value="transparent" />
        		<param name="swfversion" value="6.0.65.0" />        		
        	    <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->        	    
        	    <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
        	    <!--[if !IE]>-->
        	    <object type="application/x-shockwave-flash" data="{static_url()}static/default/frontend/swf/giai_thuong.swf" width="300" height="250">
        	      <!--<![endif]-->
        	      <param name="quality" value="high" />
        	      <param name="wmode" value="transparent" />        	      
        		<param name="swfversion" value="6.0.65.0" />        	      
        	      <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
        	      <div>
        	        <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
        	        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="{static_base()}images/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
      	        </div>
        	      <!--[if !IE]>-->
      	      </object>
        	    <!--<![endif]-->
      	    </object>
				</div>
                <div class="item"><a target="_blank" href="http://vietnamidol.com.vn/"><img src="{static_frontend()}images/upload/ad-3.jpg" alt="" /></a></div>
            </div>
        </div>
    </div>                
</div>
<style type="text/css">
.paging-bar .pagination 
{
float: right;
}
.paging-bar .pagination ul,
.paging-bar .pagination li 
{
display: inline; padding: 0 2px;
}
.paging-bar .pagination li .active,
.paging-bar .pagination li a:hover 
{
text-decoration: none; color: #00aeff;
}
.list-news .list li .desc h4 {
    height: auto;
    overflow: auto;
}
</style>