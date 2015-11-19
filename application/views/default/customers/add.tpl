{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * ADD Customers
 * 
 * @package PenguinFW
 * @subpackage customers
 * @version 1.0.0
 */

*}
{literal}
<script type="text/javascript">
     function validate()
    {
        var errors = 0;
        
        //valate name
        var name = $("[name='name']");
        
        if(name.val() == "")
        {
            $("#error_name").text("Bắt buộc");
            name.css("border","1px solid red");
            errors++;
         }
         else
            {
                $("#error_name").text("");
                name.css("border","2px solid green");
            }
       
       //valate dia chi
        var name = $("[name='region']");
        
        if(name.val() == "")
        {
            $("#error_region").text("Bắt buộc");
            name.css("border","1px solid red");
            errors++;
         }
         else
            {
                $("#error_region").text("");
                name.css("border","2px solid green");
            }
       
          
       //valate dien thoai
        var name = $("[name='phone']");
        var pat = /^[0-9]+[0-9\.\-\s]+[0-9]+$/; 
        
        if(name.val() == "")
        {
            $("#error_phone").text("Bắt buộc");
            name.css("border","1px solid red");
            errors++;
         }
         else if(pat.test(name.val()) == false || name.val().length < 6)
         {
            $("#error_phone").text("Không hợp lệ");
            name.css("border","1px solid red");
            errors++;
         }
         else
            {
                $("#error_phone").text("");
                name.css("border","2px solid green");
            }
   
              //valate email
        var name = $("[name='email']");
      
        var pat = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,4}$/; 
        
        if(name.val() == "")
        {
            $("#error_email").text("Bắt buộc");
            name.css("border","1px solid red");
            errors++;
         }
         else if(pat.test(name.val()) == false)
         {
            $("#error_email").text("Không hợp lệ");
            name.css("border","1px solid red");
            errors++;
         }
         else
            {
                $("#error_email").text("");
                name.css("border","2px solid green");
            }
                var t = check_captcha();
                    
       if(t && errors == 0 )
           {
      
               return true;
           
               }
       else 
           {
         
         
                     return false;
               }
     }
         
    function check_captcha()
        {
           //valate captcha
        var CAPTCHA_LENGTH = 5;
            
            var check  = false;
        var name = $("[name='captcha']");
            
        if(name.val() == "")
        {
            $("#error_captcha").text("Bắt buộc");
            name.css("border","1px solid red");
            return false;
         }
         else if(name.val().length != CAPTCHA_LENGTH)
         {
            $("#error_captcha").text("Không hợp lệ");
            name.css("border","1px solid red");
            return false;
         }
         else
            {
                jQuery.ajaxSetup({async:false});
                    
                $.get("/index.php/customers/check_captcha/" + name.val(),

			function(data)
			{
               
                          if(data == 0)
                              {
                                 $("#error_captcha").text("Chưa chính xác");
                                name.css("border","1px solid red");
                                check=  false;
                                  }
                                      else
                                          {
                                               $("#error_captcha").text("");
                name.css("border","2px solid green");
                    check =  true;
                                              }
                       		
	}
	);
            return check;
     
            }
                
                
     }
     
    $(document).ready(function(){

    })

       
</script>
{/literal}

<div class="heading2" style="color: white; margin-bottom: 20px;">
    <h3>{lang('Vui lòng cung cấp thông tin cá nhân theo mẫu bên dưới <br/> để nhận được mẫu thử CLEAR men mới')}</h1>
</div>

    <div class="content" >

    
    
    <form action="" method="post" id="FormAddCustomers" >
        <table class="list" align="center" style="border-spacing: 9px;">
            <tbody>  
                
                <tr>
                    <td></td>
                    <td class="error">
                        {validation_errors()}
                    </td>
                    <td></td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('tên')}</td>
                    <td class="left"><input class="txt" type="text" name="name" value="{set_value('name')}" /></td>
                    <td class="error" id="error_name"></td>
                </tr>

                <tr>
                    <td class="left">{get_label('Ngày sinh')}</td>
                    <td class="left">
                    Ngày <select name="dob_day" class="txt" style="margin:0px 10px 0px 5px; width: 60px;">
                        {for $i = 1 to 31}
                              <option value="{$i}">{$i}</option>
                            {/for}
                                         
                                     </select> 
                    
                    Tháng <select name="dob_month" class="txt" style="margin:0px 10px 0px 5px; width: 60px;">
                        {for $i = 1 to 12}
                              <option value="{$i}">{$i}</option>
                            {/for}
                                         
                                     </select> 
                    Năm <select name="dob_year" class="txt" style="margin: 0px 10px 0px 5px; width: 80px;">
                        {for $i = 1970 to date('Y')}
                              <option value="{$i}">{$i}</option>
                            {/for}
                                         
                                     </select> 
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('giới tính')}</td>
                    <td class="left">
                        <select name="gender" class="txt" style="width: 80px;">
                                         <option value="0">Nữ</option>
                                         <option value="1">Nam</option>
                                         <option value="-1">Khác</option>
                                     </select>
                                     
                    </td>
                </tr>

                <tr>
                    <td class="left" colspan="2">
                    (Vui lòng cung cấp địa chỉ chính xác để mẫu thử được giao tới tận nhà)
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('Tỉnh thành')}</td>
                    <td class="left">
                        <select name="province" class="txt" style="width: 150px;">
                            {foreach $regions as $region}
                                <option value="{$region.id}">{$region.name}</option>
                            {/foreach}
                                     </select>
                                     
                    </td>
                </tr>
                
                <tr>
                    <td class="left">{get_label('Địa chỉ')}</td>
                    <td class="left"><input class="txt"  type="text" name="region" value="{set_value('region')}" /></td>
                    <td class="error" id="error_region"></td>
                </tr>

                <tr>
                    <td class="left">{get_label('Điện thoại')}</td>
                    <td class="left"><input  style="width:200px;" class="txt"  type="text" name="phone" value="{set_value('phone')}" /></td>
                    <td class="error" id="error_phone"></td>
                </tr>

                <tr>
                    <td class="left">{get_label('Email')}</td>
                    <td class="left"><input class="txt" style="width:200px;"  type="text" name="email" value="{set_value('email')}" /></td>
                    <td class="error" id="error_email"></td>
                </tr>
                
                 <tr>
                    <td class="left">{get_label('Mã xác nhận')}</td>
                    <td class="left">
                        <div style="float: left; margin-right: 20px;" ><input class="txt" style="width:100px;"  type="text" name="captcha" value="" />
                       </div>
                        <div>{$captcha}</div>
                    </td>
                    <td class="error" id="error_captcha"></td>
                </tr>
                
                <tr>
                    <td></td><td><input onclick="return validate()" align="center" type="submit" value="" id="btn_send" /></td>
                </tr>

            </tbody>           
     
        </table>
           
                    
    </form>

</div>

                    
                    