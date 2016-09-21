<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>三颗糖后台管理</title>
<link href="<?php echo static_url('static/admin/css/main.css');?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo static_url('static/admin/js/plugins/ui/jquery-1.7.1.min.js');?>"></script>

<!--dialog弹出框-->
<link href="<?php echo static_url('static/artdialog/css/ui-dialog.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo static_url('static/artdialog/dist/dialog-min.js');?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/artdialog/dist/dialog-plus-min.js');?>"></script>
<!--dialog弹出框-->

<script type="text/javascript" src="<?php echo static_url('static/admin/js/plugins/ui/admincommon.js');?>"></script>


</head>

<body class="no-background">

	<!-- Fixed top -->
	<div id="top">
		<div class="fixed">
			<!-- <span class="logo"><img src="<?php echo static_url('static/admin/img/logo.png');?>" alt="" /></span> -->
			<!-- <ul class="top-menu">
				<li class="dropdown">
					<a class="login-top" data-toggle="dropdown"></a>
					<ul class="dropdown-menu pull-right">
						<li><a href="#" title=""><i class="icon-group"></i>Change user</a></li>
						<li><a href="#" title=""><i class="icon-plus"></i>New user</a></li>
						<li><a href="#" title=""><i class="icon-cog"></i>Settings</a></li>
						<li><a href="#" title=""><i class="icon-remove"></i>Go to the website</a></li>
					</ul>
				</li>
			</ul> -->
		</div>
	</div>
	<!-- /fixed top -->


    <!-- Login block -->
    <div class="login">
        <div class="navbar">
            <div class="navbar-inner">
                <h6><i class="icon-user"></i>管理员登录</h6>
                <!-- <div class="nav pull-right">
                    <a href="#" class="dropdown-toggle navbar-icon" data-toggle="dropdown"><i class="icon-cog"></i></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="#"><i class="icon-plus"></i>Register</a></li>
                        <li><a href="#"><i class="icon-refresh"></i>Recover password</a></li>
                        <li><a href="#"><i class="icon-cog"></i>Settings</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="well">
            <form action="<?php echo site_url('home/login');?>" method="post" class="form-horizontal" name="form" id="form">
                <div class="control-group">
                    <div class="controls" style="margin-left: 0px;">
                        用户名：<input type="text" id="admin_name" name="admin_name" placeholder="" style="width:250px;"/>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls" style="margin-left: 0px;">
                        密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="admin_pass" placeholder="" style="width:250px;"/>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls" style="margin-left: 0px;">
                        验证码：<input type="text" name="captcha" placeholder="" style="width:137px;" />&nbsp;&nbsp;&nbsp;
                        <img id="img-captcha" src="<?php echo site_url('checkcode?' . time())?>"/>
                    </div>
                </div>
                
                <!-- <div class="control-group">
                    <div class="controls" style="margin-left: 0px;">
                        随机码：<input type="text" name="phone_code" value="111111"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" disabled="" onclick="sendsms(this)">获取手机随机码</button>
                        (默认为 111111)
                    </div>
                </div> -->

                <div class="login-btn"><input type="button" onclick="javascript:subform();" onfocus="this.blur();" value="登 陆" class="btn btn-danger btn-block" id="btnReg"/></div>
            </form>
        </div>
    </div>
    <!-- /login block -->
	<script type="text/javascript">

    $('#img-captcha').click(function(){
        changeCaptcha($(this));
    });
    function changeCaptcha(obj) {
        obj.attr('src',  '<?php echo site_url('checkcode')?>' + '?' + (new Date().getTime()))
        resultconst = false;
    }

	function subform(){
		var frm = document.forms['form'];
		frm.submit();
	}

	function keyUp(e) {  
       	var currKey=0,e=e||event; 
    	currKey=e.keyCode||e.which||e.charCode;
	  	if(currKey==13){
	 		document.getElementById("btnReg").click();
	 	}
  	} 
   	document.getElementById("form").onkeydown = keyUp;

    function sendsms(obj){

        var admin_name = $("#admin_name").val();
        if(admin_name == ''){
            tanDialog('用户名未填写');return ;
        }
    
        $.ajax({
            url: "__URL__/verify",
            type: "post",
            dataType: "json",
            async:true,
            data: {"admin_name":admin_name},
            beforeSend: function(){
                
            },
            success: function(d) {
              if(d.status == 1){
                sendsmstime(obj)
              }else{

              }
              
              tanDialog(d.info);
            },
            complete:function(){
                
            }
        });
    }

    var wait=60;
    function sendsmstime(obj){
        if (wait == 0) {
            $(obj).attr("disabled", false).html('重新发送');      
            wait = 60;
        } else {
            $(obj).attr("disabled", true).html("重新发送(" + wait + ")");
            wait--;
            setTimeout(function() {
                sendsmstime(obj)
            },
            1000)
        }
    }


   </script>


	<!-- Footer -->
	<div id="footer">
		<div class="copyrights">后台管理</div>
		<!-- <ul class="footer-links">
			<li><a href="" title=""><i class="icon-cogs"></i>Contact admin</a></li>
			<li><a href="" title=""><i class="icon-screenshot"></i>Report bug</a></li>
		</ul> -->
	</div>
	<!-- /footer -->

</body>
</html>
