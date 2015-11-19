<div id="content">
    <div class="row">
        <div class="left-content">                    	
                <h2 class="ui-text ui-text-12">Tin nóng</h2>                            
                <div class="detail-news">
                    <h1>{$article.subject}</h1> 
                    <ul class="share">
                        <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$getlink}" title="Share on Facebook"><img src="{static_frontend()}images/blank.gif" alt="" class="ui-icon ui-icon-10" /></a></li>
                        <li><a target="_blank" href="http://link.apps.zing.vn/pro/view/conn/share?u={$getlink}&image={img_url()}static/default/frontend/images/logo.jpg" title="Share on Zingme"><img src="{static_frontend()}images/blank.gif" alt="" class="ui-icon ui-icon-11" /></a></li>
                        </ul>
                    <p class="date">{$article.publish_date|date_format:"%d/%m/%Y %I:%M %p"}</p>
                    <div class="fck">
                        <p>{$article.content}</p>
                    </div>                                  
            </div>	
            <div class="tool-bar"><a href="{get_link('articles', '', 'index')}" title="Quay lại" class="back">Quay lại</a></div> 				
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