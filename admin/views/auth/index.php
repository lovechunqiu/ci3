
<script type="text/javascript">
	var delUrl = "<?php echo site_url('auth/doDelete');?>";
</script>
<style>
  body{background-image:none;}
</style>
<div class="pubheit1"></div>
<div class="so_main">
  <div class="page_tit1"><h5><i class="icon-text-height"></i><?php echo $position;?>管理</h5></div>
  
  <div >
  <table class="table table-hover">
    <thead>
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">ID</th>
    <th class="line_l">用户组名称</th>
    <th class="line_l">操作</th>
  </tr>
  </thead>
  <tbody>
    <?php foreach($auth_list as $key => $value):?>
      <tr overstyle='on' id="list_<?php echo $value['id'];?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo $value['id'];?>"></td>
        <td><?php echo $value['id'];?></td>
        <td><span id="name_<?php echo $value['id'];?>"><?php echo $value['groupname'];?></span></td>
        <td>
          <?php if(get_other_auth('auth', 'edit')):?>
            <a href="<?php echo site_url('auth/edit?id=' . $value['id']);?>">编辑</a> 
          <?php endif;?>
          <?php if(get_other_auth('auth', 'dodelete')):?>
            <a href="javascript:void(0);" onclick="del(<?php echo $value['id'];?>);">删除</a>  
          <?php endif;?>
        </td>
      </tr>
    <?php endforeach;?>
  </tbody>
  </table>

  </div>
  <div class="pubheit"></div>
  <div class="toolbar">
    <li><a href="<?php echo site_url('auth/add');?>">添加用户组</a></li>
    <li><a href="javascript:void(0);" onclick="del();">删除用户组</a></li>
    <div class="nav pull-right">
      <span class="dropdown-toggle navbar-icon pagination" data-toggle="dropdown" style="border-left:none;">
        <?php echo $pagebar;?>
      </span>
    </div>
  </div>
  
</div>
