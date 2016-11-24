
<script type="text/javascript">
	var delUrl = "<?php echo site_url('adminuser/doDelete');?>";
</script>
<style>
  body{background-image:none;}
</style>
<div class="pubheit1"></div>
<div class="so_main">
  <div class="page_tit1"><h5><i class="icon-text-height"></i><?php echo $position;?>管理</h5></div>
  
  <?php $this->view('adminuser/search');?>
  <div>
  <table class="table table-hover">
    <thead>
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">ID</th>
    <th class="line_l">用户名</th>
    <th class="line_l">真实姓名</th>
    <th class="line_l">手机号</th>
    <th class="line_l">所属用户组</th>
    <th class="line_l">操作</th>
  </tr>
  </thead>
<tbody>
  <?php foreach($admin_list as $key => $vo):?>
    <tr overstyle='on' id="list_<?php echo $vo['id'];?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo $vo['id'];?>"></td>
        <td><?php echo $vo['id'];?></td>
        <td><span id="name_<?php echo $vo['id'];?>"><?php echo $vo['user_name'];?></span></td>
        <td><span id="real_name_<?php echo $vo['id'];?>"><?php echo $vo['real_name'];?></span></td>
        <td><span id="phone_<?php echo $vo['id'];?>"><?php echo $vo['mobile'];?></span></td>
        <td><span id="group_<?php echo $vo['id'];?>"><?php echo $vo['groupname'];?></span></td>
        <td>
          <?php if(get_other_auth('adminuser', 'edit')):?>
            <a href="javascript:void(0);" onclick="edit_f(<?php echo $vo['id'];?>);">编辑</a> 
          <?php endif;?>
          <?php if(get_other_auth('adminuser', 'dodelete')):?>
            <a href="javascript:void(0);" onclick="del(<?php echo $vo['id'];?>);">删除</a>  
          <?php endif;?>
        </td>
      </tr>
  <?php endforeach;?>
  </tbody>
  </table>

  </div>
  <div class="pubheit"></div>
  <div class="toolbar">
    <li><a href="javascript:void(0);" onclick="addAdminUser(1);"><span class="addAttr_action">添加<?php echo $position;?></span></a></li>
    <li><a href="javascript:void(0);" onclick="del();"s>删除<?php echo $position;?></a></li>
    <div class="nav pull-right">
      <span class="dropdown-toggle navbar-icon pagination" data-toggle="dropdown" style="border-left:none;">
        <?php echo $pagebar;?>
      </span>
    </div>
  </div>
</div>

<script type="text/javascript">
    //编辑地区
    function edit_f(uid) {
  		$("#uid").attr("disabled",false);
  		var name = $("#name_"+uid).html();
  		var real_name = $("#real_name_"+uid).html();
  		var group_name = $("#group_"+uid).html();
  		var phone = $("#phone_"+uid).html();
      var word = $("#word_"+uid).html();
  		var univalent = $("#univalent_"+uid).html();
      
  		$("#uid").val(uid);
  		$("#user_name").val(name);
  		$("#real_name").val(real_name);
  		$("#phone").val(phone);
  		$("#user_group_id").find("option").each(function(){
  			if($(this).text() == group_name) $(this).attr("selected","selected");
  		});
      $("#user_word").val(word);
  		$("#univalent").val(univalent);
  		
  		$("#showwait").val("修改");
      $("#moved").html("编辑<?php echo $position;?>");
  		$("#pass_tip").html("如果不改密码，请留空");
  		$("#pass_tip").css("color","red");
      //$("#phone").attr('disabled','disabled');
     
  		isSearchHidden = 1;
  		addAdminUser();
    }
    
</script>