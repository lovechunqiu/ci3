<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<script type="text/javascript" src="<?php echo static_url('static/admin/js/plugins/ui/jquery-1.7.1.min.js');?>"></script>
<link href="<?php echo static_url('static/admin/css/main.css');?>" rel="stylesheet" type="text/css" />
<style type="text/css">
    body{background-image:none;min-height: 0px;}
    .wlft{position:relative;left:90px;}
    .wlft1{position:relative;left:228px;}
    .wlft2{position:relative;left:155px;}
    .pubheit{height:10px;}
</style> 
<div class="pubheit"></div>
<h5 class="widget-name"><i class="icon-text-height"></i>欢迎页</h5>
<div class="widget">
    <div class="navbar-inner">
        <h6>欢迎登陆</h6>
        <div class="nav pull-right" style="padding:10px 5px;">
            当前时间&nbsp;<span id="clock"></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showLocale(objD)
    {
        var str,colorhead,colorfoot;
        var yy = objD.getYear();
        if(yy<1900) yy = yy+1900;
        var MM = objD.getMonth()+1;
        if(MM<10) MM = '0' + MM;
        var dd = objD.getDate();
        if(dd<10) dd = '0' + dd;
        var hh = objD.getHours();
        if(hh<10) hh = '0' + hh;
        var mm = objD.getMinutes();
        if(mm<10) mm = '0' + mm;
        var ss = objD.getSeconds();
        if(ss<10) ss = '0' + ss;
        var ww = objD.getDay(); 
        <!------------可以从这里调整字体颜色--------------->
        if  ( ww==0 ){ colorhead="<font color=\"#ffffff\">";}
        if  ( ww > 0 && ww < 6 ){colorhead="<font color=\"#ffffff\">";}
        if  ( ww==6 ){colorhead="<font color=\"#ffffff\">";}
        
        <!-------------------结束------------------------------>
        var www = '';
        if  (ww==0)  www="星期日";
        if  (ww==1)  www="星期一";
        if  (ww==2)  www="星期二";
        if  (ww==3)  www="星期三";
        if  (ww==4)  www="星期四";
        if  (ww==5)  www="星期五";
        if  (ww==6)  www="星期六";
        colorhead = "<font>";
        colorfoot="</font>";
        str = colorhead + yy + "-" + MM + "-" + dd + " " + hh + ":" + mm + ":" + ss + "  " + www+ colorfoot;
        return(str);
    }
    function tick()
    {
        var today;
        today = new Date();
        document.getElementById("clock").innerHTML = showLocale(today);
        window.setTimeout("tick()", 1000);
    }
    tick();
</script>  
<!-- Headings -->
<div class="row-fluid">
    <!-- Column -->
    <div class="span6">
    
        <!-- Headings, standard font -->
        <div class="widget">
            <div class="navbar"><div class="navbar-inner"><h6>个人信息</h6></div></div>
            <div class="well body">
                <p>您好，<?php echo $user['user_name'];?></p>
                <p>所属角色：<?php echo $user['groupname'];?></p>
                <p>上次登录时间：<?php echo date('Y-m-d H:i:s', $user['last_log_time']);?></p>
                <p>上次登录IP：<?php echo $user['last_log_ip'];?></p>
            </div>
        </div>
        <!-- /headings, standard font -->

    </div>
    <!-- /column -->
    
    <!-- Column -->
    <div class="span6">
    
        <!-- Headings, standard font -->
        <div class="widget">
            <div class="navbar"><div class="navbar-inner"><h6>个人信息</h6></div></div>
            <div class="well body">
                <p>您好，<?php echo $user['user_name'];?></p>
                <p>所属角色：<?php echo $user['groupname'];?></p>
                <p>上次登录时间：<?php echo date('Y-m-d H:i:s', $user['last_log_time']);?></p>
                <p>上次登录IP：<?php echo $user['last_log_ip'];?></p>
            </div>
        </div>
        <!-- /headings, standard font -->

    </div>
    <!-- /column -->
    
</div>
<!-- /headings -->
