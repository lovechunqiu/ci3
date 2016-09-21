<style>
  body{background-image:none;}
  .pubheit{height:10px;}
</style>
<div class="pubheit"></div>
<h5 class="widget-name"><i class="icon-text-height"></i>站点配置</h5>

<!-- 搜索用户 -->

<div id="searchUser_div" style="display:none;">
<form class="form-horizontal" method="post" action="<?php echo site_url('setting/add');?>" onsubmit="return false;">
  <fieldset>
    <div class="row-fluid">
      <div class="navbar">
        <div class="navbar-inner">
          <h6>添加新参数 [ <a href="javascript:void(0);" onclick="addWebSetting();">隐藏</a> ]</h6>
        </div>
      </div>
      <div class="well">
        <div class="control-group">
          <label class="control-label">参数名称：</label>
          <div class="controls">
            <input class="span4" type="text" name="name" id="name">
            便于自己知道此参数的作用的名称
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">参数代码：</label>
          <div class="controls">
            <input class="span4" type="text" name="code" id="code">
            在模板中引用的代码，尽量不要和系统变更重命，可以加前缀，如ttxf_
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">参数类型：</label>
          <div class="controls">
            <select name="type" class="span4" id="type">
              <option value="input">单行文本</option>
              <option value="textarea">多行文本</option>
            </select>
            参数的类型：单行文本所保存内容较小，多行文本可保存较多内容
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">参数说明：</label>
          <div class="controls">
            <input class="span4" type="text" name="tip" id="tip">
            用来更详细的说明此参数的作用
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">参数排序：</label>
          <div class="controls">
            <input class="span4" type="text" name="order_sn" id="order_sn" value="0">
            参数在管理列表中的排序，越大越靠前
          </div>
        </div>
        <div class="form-actions align-left">
          <button class="btn btn-primary" type="submit" id="showwait" onclick="addNewSetting();">添加</button>
        </div>
      </div>
    </div>
  </fieldset>
</form>  
<div class="pubheit"></div>
</div>

<script type="text/javascript">
function addNewSetting(){
  var name=$("#name").val();
  var code=$("#code").val();
  var type=$("#type").val();
  var tip=$("#tip").val();
  var order_sn=$("#order_sn").val();
  
  if(name==""){
    tanDialog('参数名不能为空');
    $("#name").focus();
    return false;
  }else if(code==""){
    tanDialog('参数代码不能为空');
    $("#code").focus();
    return false;
  }else if(!order_sn.match(/^[\d]+$/)){
    tanDialog('参数排序只能为数字');
    $("#order_sn").focus();
    return false;
  }
  
  var datas = {'name':name,'code':code,'type':type,'order_sn':order_sn,'tip':tip};
  $.post("<?php echo site_url('setting/doAdd');?>", datas,addSettingResponse,'json');
}

 function addSettingResponse(res){
  if(!res.status){
    tanDialog(res.info);
  }else{
    var name=$("#name").val('');
    var code=$("#code").val('');
    var type=$("#type").val('');
    var tip=$("#tip").val('');
    var order_sn=$("#order_sn").val('');
    tanDialog('新增成功');
  }
 }
 </script> 

<!-- 搜索用户 -->

<form class="form-horizontal" method="post" action="<?php echo site_url('setting/doEdit');?>">
  <fieldset>
    <div class="row-fluid">
      <div class="navbar">
        <div class="navbar-inner">
          <h6>
          	<a href="javascript:void(0);" onclick="addWebSetting();">
          		<span class="searchUser_action">添加新参数</span>
          	</a>
          </h6>
        </div>
      </div>
      <div class="well">
        <?php foreach($list as $key => $value):?>
	        <div class="control-group" id="line_<?php echo $value['id'];?>">
	          	<label class="control-label">
	        		<a href="javascript:void(0);" style="display:none;" onclick="delx('<?php echo $value['id'];?>');" class="a_del" title="删除此条数据">X&nbsp;&nbsp;</a>
	          		<?php echo $value['name'];?>：
	          	</label>
	          	<div class="controls">
                <?php $dis = " ";?>
                  <?php if($value['dis_abled'] == 1):?>
                    <?php $dis = "disabled";?>
                  <?php endif;?>
                <?php if($value['type'] == 'textarea'):?>
      						<textarea <?php echo $dis;?> name="<?php echo $value['id'];?>" class="span4"><?php echo $value['text'];?></textarea>
      					<?php else:?>
      						<input <?php echo $dis;?> name="<?php echo $value['id'];?>" class="span4" type="text" value="<?php echo $value['text'];?>">
      					<?php endif;?>
                <?php if( ! empty($value['tip'])):?>
                  <?php echo $value['tip'] . '(' . $value['code'] . ')';?>
                <?php else:?>
                  <?php echo $value['code'];?>
                <?php endif;?>
	          	</div>
	        </div>
	      <?php endforeach;?>
        <div class="form-actions align-left">
          <input type="hidden" name="fid" id="fid"/>
          <button class="btn btn-primary" type="submit">确定</button><span style="color:#CCCCCC"> (所有方式修改提交一次即可)</span>
        </div>
      </div>
    </div>
  </fieldset>
</form>  

<script type="text/javascript">

$(document).ready(function(){
	$(".control-label").mouseover(function(){
			$(this).find(".a_del").css({"display":"block","float":"left"})
		}
	)
	$(".control-label").mouseleave(function(){
			$(this).find(".a_del").css("display","none")
		}
	)
});
function delx(id){

  top.dialog({
    title:'消息',
    content:'您确定要删除这些记录吗？',
    id:'dd',
    zIndex: 1100,
    button: [
        {
          value: '同意',
          callback: function () {
            var datas = {'id':id};
            $.post("<?php echo site_url('setting/doDelweb');?>", datas,delSettingResponse,'json');
          },
          autofocus: true
        },
        {
          value: '取消'
        }
    ]
  }).showModal();

}

function delSettingResponse(res){
	if(res.status){
	  $("#line_"+res.id).css("display","none");
	}
  var msg = res.message;
  tanDialog(msg);
}

var isSearchHidden = 1;
function addWebSetting() {
	if(isSearchHidden == 1) {
		$("#searchUser_div").slideDown("fast");
		$(".searchUser_action").html("添加完毕");
		isSearchHidden = 0;
	}else {
		$("#searchUser_div").slideUp("fast");
		$(".searchUser_action").html("添加新参数");
		isSearchHidden = 1;
	}
}

</script>
