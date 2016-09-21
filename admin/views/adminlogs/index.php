
<script type="text/javascript">
	var delUrl = "<?php echo site_url('adminlogs/doDelete');?>";
  var isSearchHidden = 1;
  var searchName     = "<?php echo $search_name;?>";
</script>
<style>
  body{background-image:none;}
</style>
<div class="pubheit1"></div>
<div class="so_main">
  <div class="page_tit1"><h5><i class="icon-text-height"></i><?php echo $position;?>管理</h5></div>
  
  <?php $this->view('adminlogs/dosearch');?>

  <div class="toolbar">
    <li><a href="javascript:void(0);" onclick="dosearch();"><span class="search_action"><?php echo $search_name;?></span></a></li>
    <div class="nav pull-right">
      <span class="dropdown-toggle navbar-icon pagination" data-toggle="dropdown" style="border-left:none;">
        <?php echo $pagebar;?>
      </span>
    </div>
  </div>
  <div class="pubheit"></div>
  
  <div>
  <table class="table table-hover">
    <thead>
  <tr>
    <th class="line_l">ID</th>
    <th class="line_l">描述</th>
    <th class="line_l">操作者</th>
    <th class="line_l">手机号</th>
    <th class="line_l">添加时间</th>
  </tr>
  </thead>
<tbody>
  <?php foreach($list as $key => $value):?>
    <tr overstyle='on' id="list_<?php echo $value['id'];?>">
      <td><?php echo $value['id'];?></td>
      <td><span id="addr_<?php echo $value['id'];?>"><?php echo $value['desc'];?></span></td>
      <td><span id="community_<?php echo $value['id'];?>"><?php echo $value['name'];?></span></td>
      <td><span><?php echo ! empty($value['mobile']) ? $value['mobile'] : '';?></span></td>
      <td><span><?php echo date('Y-m-d H:i:s', $value['created_time']);?></span></td>
    </tr>
  <?php endforeach;?>
  </tbody>
  </table>

  </div>
  
</div>

<script type="text/javascript">
    //编辑地区
    function edit_f(id) {
  		$("#id").attr("disabled",false);
      var addr      = $("#addr_"+id).html();
  		var community = $("#community_"+id).html();

  		$("#id").val(id);
      $("#addr").val(addr);
      $("#community").val(community);

  		$("#showwait").val("修改");
      $("#moved").html("编辑<?php echo $position;?>");
     
  		isSearchHidden = 1;
  		addMusic();
    }
    
</script>