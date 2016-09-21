<include file="Public:_header" />
<tagLib name="htmlA" />
<script type="text/javascript">
	var setUrl = '__URL__/set.html';
	var tableUrl = '__URL__/showtable.html';
	var setTitle = '备份参数';
	var strTitle = '查看表结构';
</script>
<style>
  body{background-image:none;}
</style>
<link rel="stylesheet" type="text/css" href="__ROOT__/statics/newadmin/css/addpubl.css">
<div class="pubheit1"></div>
<div class="so_main">
  <div class="page_tit1"><h5><i class="icon-text-height"></i>清空数据表</h5></div>
  <div style="height:200px; line-height:200px; text-align:center;">
  <form name="xx" method="post" action="__URL__/truncate">
  <input name="ee" value="" style="display:none"/>
  <input type="submit" onclick="javascript:if(confirm('确定要清空数据吗？清空后所有数据都将被删除，并且不可恢复！')) return true;else return false;" value="清空数据" style="height:50px; width:100px" />
  </form>
  </div>
<include file="Public:_footer" />