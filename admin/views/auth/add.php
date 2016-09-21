<style type="text/css">
.lineD dt b{color:#0C0}
body{background-image:none;}
</style>
<div class="pubheit"></div>
<div class="so_main">
  <div class="page_tit1"><h5><i class="icon-text-height"></i>用户级权限配置</h5></div>
  
  <div class="form2" style="border:1px solid #D5D5D5">
  	<form method="post" action="<?php echo site_url('auth/doAdd');?>">
    <dl class="lineD">
      <dt class="t">用户组名称：</dt>
	  <dd><input type="text" name="groupname" id="groupname" class="input" value="" /></dd>
    </dl>
	
	<?php foreach($auth_list as $ke => $vo): ?>
	
    <dl class="lineD">
      <dt class="t"><b><?php echo $vo['low_title']['0'];?></b></dt>
	  <dd>请选择相关权限<input type="checkbox" onclick="select_all('fa<?php echo $ke;?>');" id="fa<?php echo $ke;?>" /><label for="fa<?php echo $ke;?>">全选</label></dd>
    </dl>
	
		<?php foreach($vo['low_leve'] as $fmodel => $vs): ?>
			<?php foreach($vs as $keyname => $item): ?>
				<?php if($keyname != "data"): ?>
					<dl class="lineD">
					  <dt><?php echo $keyname;?>：</dt>
					  <dd>
							<?php foreach($item as $itemname => $itemkey): ?>
							<input data="fa<?php echo $ke;?>_son" type="checkbox" name="model[<?php echo $fmodel;?>][]" class="check" value="<?php echo $itemkey;?>" id="<?php echo $fmodel . $itemkey;?>"><label for="<?php echo $fmodel . $itemkey;?>"><?php echo $itemname;?></label>
							<?php endforeach;?>
					  </dd>
					</dl>
				<?php endif;?>
			<?php endforeach;?>
		<?php endforeach;?>
		
	<?php endforeach;?>

    <div class="form-actions align-left" style="border:none;">
		<input class="btn btn-primary" type="submit" value="添加">
		<input type="button" class="btn btn-primary" value="返回" onclick="javascript:history.back();"/>
	</div>
	
	</form>
  </div>

</div>
<script>
function select_all(id){
	var se = id+"_son";
	if($("#"+id).attr('checked')){
		$("input:[data="+se+"]").each(function(i,obj){
			obj.checked = true;
		});
	}else{
		$("input:[data="+se+"]").each(function(i,obj){
			obj.checked = false;
		});
	}

}

$(document).ready(function(){
	$(".lineD").mouseover(function(){
			$(this).find(".a_del").css("display","block")
		}
	)
	$(".lineD").mouseleave(function(){
			$(this).find(".a_del").css("display","none")
		}
	)
});

</script>
