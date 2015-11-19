<div class="wrap">
    <div class="main">
        <div class="content">
            <div class="wrapper content_news">
                <div class="title number">
                    <figure><span>Hình ảnh</span></figure>
                </div> 
                <div class="section group">
                    {if isset($photo_detail.0)}
                        <div class="image-show">
                            <img src="{media_url()}images/{$photo_detail.0.image_name}" />
                        </div>
                        <div class="image-detail">
                            <h3>{$photo_detail.0.name}</h3>
                            <h4>{$photo_detail.0.username}</h4>
                            <h4 id="counter_vote">{$photo_detail.0.counter_vote} Vote</h4>
                            <h4>{$photo_detail.0.counter_view+1} View</h4>
                            {if $enable_vote == -1}
                                <h3>Vui lòng <a href="{base_url()}mobile/login" style="color: #0033ff">Đăng nhập</a> để bình chọn!</h3>
                            {elseif $enable_vote == 1}
                                <a class="btn-vote" id="btn_vote">Bình Chọn</a>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#btn_vote").click(function() {
                                            $.ajax({
                                                type: "POST",
                                                url: "{base_url()}mobile/vote",
                                                data: {
                                                    token: "{generate_voting_params('photo',$photo_detail.0.id, 1, 'counter_vote', 2)}"
                                                },
                                                success: function() {
                                                    $("#btn_vote").remove();
                                                    $(".image-detail").append('<h3>Bạn đã bình chọn rồi!</h3>');
                                                    $("#counter_vote").html('{$photo_detail.0.counter_vote+1} Vote');
                                                }
                                            });
                                        });
                                    });
                                </script>
                            {else}
                                <h3>Bạn đã bình chọn rồi!</h3>
                            {/if}
                        </div>
                    {else}
                        <center><h1>Thông tin hình ảnh không tồn tại!</h1></center>
                        {/if}
                </div>
            </div>
        </div>
    </div> 
</div>