
<form method="post" action="">
  <fieldset>
    <div class="widget row-fluid">
      <div class="well">
        <!-- <div class="control-group">
          <div class="controls">
            	短信验证码：<input type="text" name="smscode" id="smscode">&nbsp;&nbsp;&nbsp;
            	<button type="button" onclick="sendsms(this);" class="btn btn-primary">免费获取验证码</button>
          </div>
        </div> -->
        <div class="control-group">
          <div class="controls">
            	新的手机号：<input type="text" name="phone" id="phone">
          </div>
        </div>
        <div class="form-actions align-left">
          <button id="showwait" class="btn btn-primary" onclick="subphone();" type="button">确定</button>
        </div>
      </div>
    </div>
  </fieldset>
</form>

<script type="text/javascript">
  
  function subphone(){
    
    //判断手机
    var smscode = $("#smscode").val();
    var phone = $("#phone").val();
    var pre = /^((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}$/;
    
    // if(smscode == ''){
    //   fnTip('验证码不能为空');return false;
    // }
    if(phone == ''){
    	fnTip('手机号不能为空');return false;    
    }
    if(!pre.test(phone)){
    	//fnTip('手机号格式不正确');return false;
    }
    
    var pata = {smscode:smscode,phone:phone,type:4};

    $.ajax({
        url: "<?php echo site_url('home/checkphone');?>",
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
        data:{type:4},
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
