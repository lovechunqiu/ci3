
<!-- search-->
<div id="addAttr_div" style="display:none;">
<form class="form-horizontal" method="post" action="<?php echo site_url('adminuser/addAdmin');?>" onsubmit="return addNewAdmin();">
  <fieldset>
    <div class="row-fluid">
      <div class="navbar">
        <div class="navbar-inner">
          <h6><span id="moved">添加<?php echo $position;?></span> [ <a href="javascript:void(0);" onclick="addAdminUser();">隐藏</a> ]</h6>
        </div>
      </div>
      <div class="well">
        <div class="control-group">
          <label class="control-label">管理员用户名：</label>
          <div class="controls">
            <input class="span4" type="text" id="user_name" name="user_name" id="id" >
            管理员登陆时的用户中
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">管理员密码：</label>
          <div class="controls">
            <input name="user_pass" class="span4" id="user_pass" type="password" value="">
            登陆员登陆时的密码,密码不区分大小写
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">真实姓名：</label>
          <div class="controls">
            <input name="real_name" class="span4" id="real_name" type="text" value="">
            管理员的真实姓名
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">手机号：</label>
          <div class="controls">
            <input name="mobile" class="span4" id="phone" type="text" value="">
            <span id="phoneContent">管理员的手机号</span>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">所属用户组：</label>
          <div class="controls">
            <select name="user_group_id" class="span4" id="user_group_id">
              <?php if( ! empty($is_show) && $is_show == 1):?>
                <option value="6">商家</option>
              <?php else:?>
                <?php foreach($group_list as $key => $value):?>
                  <option value="<?php echo $value['id'];?>"><?php echo $value['groupname'];?></option>
                <?php endforeach;?>
              <?php endif;?>
            </select>
            不同的用户组对应不同的权限
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">密码口令：</label>
          <div class="controls">
            <input name="user_word" class="span4" id="user_word" type="password">
            管理员密码口令设置后，在后台登录时只有写对口令才能进入后台（可填写文字、字母或数字，如：客服1号）
          </div>
        </div>
      </div>
    </div>
    <div class="form-actions align-left">
      <input type="hidden" name="uid" id="uid" value="" disabled="disabled"/>
      <input type="submit" class="btn btn-primary" id="showwait" value="添加" />
    </div>
  </fieldset>
</form>  
<div class="pubheit"></div>
</div>

<div class="suggestion_wrap" id="suggestion_wrap" style="display:none">
  <div class="suggestion_box">
    <ul id="suggestion_con">
    </ul>
  </div>
</div>
<script type="text/javascript">
//hover
function csshove(obj){
  $(obj).addClass("lihover"); 
}
function cssout(obj){
  $(obj).removeClass("lihover"); 
}
function clic(obj){
  var id = $(obj).attr("data"); 
  $("#game_name").val($(obj).html());
  $("#suggestion_wrap").hide();
}

</script>
 <script type="text/javascript">
 function addNewAdmin(){
  
  var is_edit = !$("#uid").attr("disabled");
  var name=$("#user_name").val();
  var pass=$("#user_pass").val();
  var word=$("#user_word").val();
  var phone =$("#phone").val();

  var regphone = /^(13|15|18|17|16|14)[0-9]{9}$/;
  if(!regphone.test(phone)){
      tanDialog('您输入的手机号码长度或格式错误');
      return false;
  }
  
  if(name==""){
    tanDialog('管理员用户名不能为空');
    $("#user_name").focus();
    return false;
  }else if(pass == "" && is_edit == false){
    tanDialog('管理员密码不能为空');
    $("#user_pass").focus();
    return false;
  }else if(word == "" && is_edit == false){
    tanDialog('管理员密码口令不能为空');
    $("#user_word").focus();
    return false;
  }else{
    return true;
  }
}

var isSearchHidden = 1;
function addAdminUser(num) {

  if(num == 1){
    $("#uid").val("");
    $("#user_name").val("");
    $("#real_name").val("");
    $("#user_group_id").find("option").each(function(){
      if($(this).text() == 5) $(this).attr("selected","selected");
    });
    $("#user_word").val("");
    $("#uid").attr("disabled","true");
    $("#showwait").val("添加");
    $("#moved").html("添加<?php echo $position;?>");
    
  }

  if(isSearchHidden == 1) {
    $("#addAttr_div").slideDown("fast");
    $(".addAttr_action").html("添加完毕");
    isSearchHidden = 0;
  }else {
    $("#addAttr_div").slideUp("fast");
    $(".addAttr_action").html("添加<?php echo $position;?>");
    isSearchHidden = 1;
  }
}
</script> 