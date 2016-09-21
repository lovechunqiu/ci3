
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
    <th class="line_l">文件夹名称</th>
    <th class="line_l">备份时间</th>
    <th class="line_l">备份说明</th>
    <th class="line_l">大小</th>
  </tr>
  </thead>
<tbody>
    <?php $total_szie = 0;foreach($baklist as $key => $value):?>
      <tr overstyle='on' id="list_<?php echo $value['dirname'];?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo $value['dirname'];?>"></td>
        <td><?php echo $key;?></td>
        <td><?php echo $value['dirname'];?></td>
        <td width="130px"><?php echo $value['baktime'];?></td>
        <td width="350px"><?php echo $value['bakdetail'];?></td>
        <td><?php echo getMb($value['baksize']);$total_szie+=$value['baksize'];?></td>
      </tr>
    <?php endforeach;?>
  <tr><td colspan="7" align="right">备份总大小：<?php echo getMb($total_szie);?></td></tr>
  </tbody>
  </table>

  </div>

</div>

