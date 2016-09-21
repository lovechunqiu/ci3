
<form method="post" action="">
  <fieldset>
    <div class="widget row-fluid">
      <div class="well">
        <div class="control-group">
          <div class="controls">
            输入原密码：<input type="password" name="oldpass" id="oldpass" style="width:100px;">&nbsp;&nbsp;
            输入新密码：<input type="password" name="newpass" id="newpass"style="width:100px;">&nbsp;&nbsp;
            确认新密码：<input type="password" name="newpass1" id="newpass1"style="width:100px;">&nbsp;&nbsp;
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            输入原口令：<input type="password" name="oldword" id="oldword" style="width:100px;">&nbsp;&nbsp;
            输入新口令：<input type="password" name="newword" id="newword" style="width:100px;">&nbsp;&nbsp;
            确认新口令：<input type="password" name="newword1" id="newword1" style="width:100px;">&nbsp;&nbsp;
          </div>
        </div>
        <!-- <div class="control-group">
          <div class="controls">
            短信验证码：<input type="text" name="smscode" id="smscode" style="width:170px;">&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="sendsms(this);" class="btn btn-primary">免费获取验证码</button>
          </div>
        </div> -->
        <div class="form-actions align-left">
          <button id="showwait" class="btn btn-primary" onclick="sub();" type="button">确定</button>
        </div>
      </div>
    </div>
  </fieldset>
</form>

<script type="text/javascript">
  
  function sub(){
    
    //判断手机
    var smscode = $("#smscode").val();
    var oldpass = $("#oldpass").val();
    var newpass = $("#newpass").val();
    var newpass1 = $("#newpass1").val();
    var oldword = $("#oldword").val();
    var newword = $("#newword").val();
    var newword1 = $("#newword1").val();
    
    if(smscode == ''){
      fnTip('验证码不能为空');return false;
    }
    if(oldpass == ''){
      fnTip('原密码不能为空');return false;
    }
    if(oldword == ''){
      fnTip('原口令不能为空');return false;
    }
    if(newpass != newpass1){
      fnTip('原密码和新密码不一致');return false;
    }
    if(newword != newword1){
        fnTip('原口令和新口令不一致');return false;
    }
    var pata = {smscode:smscode,oldpass:oldpass,newpass:newpass,newpass1:newpass1,oldword:oldword,newword:newword,newword1:newword1,type:3};

    $.ajax({
        url: "<?php echo site_url('home/checkpass');?>",
        type: "post",
        dataType: "json",
        data:pata,
        async:true,
        success: function(d) {
          
          if(d.status == 1){
        	  fnTip(d.info)
        	  closedialog();
          }else{
        	  fnTip(d.info)
          }
        }
    });
  }


  function sendsms(obj){
    
    $.ajax({
        url: "<?php echo site_url('home/sendsms');?>",
        type: "post",
        dataType: "json",
        async:true,
        data:{type:3},
        beforeSend: function(){
            sendsmstime(obj)
        },
        success: function(d) {
          if(d.status == 1){

          }else{

          }
          
          fnTip(d.info);
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

function fnTip(msg){
  var d = top.dialog({ content: msg });
  d.show();
  setTimeout(function () {
      d.close().remove();
  }, 2000);
}

//关闭dialog框
function closedialog(){
	setTimeout(function () {
  	  var po = top.dialog({id:'dd'});
		  po.close().remove();
	  }, 2000);
}

</script>
