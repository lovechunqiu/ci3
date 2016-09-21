<script type="text/javascript">
	var setUrl = "<?php echo site_url('db/set');?>";
	var tableUrl = "<?php echo site_url('db/showtable');?>";
	var setTitle = '备份参数';
	var strTitle = '查看表结构';
</script>
<style>
  body{background-image:none;}
</style>
<div class="pubheit1"></div>
<div class="so_main">
  <div class="page_tit1"><h5><i class="icon-text-height"></i>数据库管理</h5></div>

  <div>
  <table class="table table-hover">
    <thead>
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">序号</th>
    <th class="line_l">表名</th>
    <th class="line_l">引擎</th>
    <th class="line_l">编码</th>
    <th class="line_l">记录数</th>
    <th class="line_l">大小</th>
    <th class="line_l">最后更新时间</th>
    <th class="line_l">操作</th>
  </tr>
  </thead>
<tbody>
    <?php $total_szie = 0; foreach($tablelist as $key => $value):?>
      <tr overstyle='on' id="list_<?php echo $value['Name'];?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo $value['Name'];?>"></td>
        <td><?php echo $key;?></td>
        <td><?php echo $value['Name'];?></td>
        <td><?php echo $value['Engine'];?></td>
        <td><?php echo $value['Collation'];?></td>
        <td><?php echo $value['Rows'];?></td>
        <td><?php echo getMb($value['Data_length']+$value['Index_length']);$total_szie+=($value['Data_length']+$value['Index_length']);?></td>
        <td><?php echo isset($value['Update_time']) ? $value['Update_time'] : $value['Create_time'];?></td>
        <td>
            <a href="javascript:showtable('<?php echo $value['Name'];?>')">查看表结构</a> 
        </td>
      </tr>
    <?php endforeach;?>
  <tr><td colspan="9" align="right">数据库总大小：<?php echo getMb($total_szie);?></td></tr>
  </tbody>
  </table>

  </div>
    <div class="pubheit"></div>
  <div class="toolbar">
    <li><a href="javascript:void(0);" onclick="bakup();"><span class="search_action">备份所选表</span></a></li>
    
  </div>
  
</div>
<script type="text/javascript">
function bakup(){
	var table = getChecked();

	if(table=="") {
		tanDialog("请选择要备份的表");
		return false;
	}
	showDialog(setUrl, setTitle,"POST",{"tables":table});
}
function showtable(table){
	if(table=="") {
		return false;
	}
	showDialog(tableUrl+"?tables="+table, strTitle);
}
</script>
