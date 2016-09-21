<tagLib name="htmlA" />
<div class="pubheit1"></div>
<div class="so_main">
<div class="page_tit1"><h5><i class="icon-text-height"></i>为了安装，建议下载完成后删除备份</h5></div>
<div class="form-horizontal">
	<div id="tab_1" style="overflow:hidden">
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<a href="{$downurl}" target="_blank">下载ZIP备份</a>
			</div>
		</div>
		<!-- <div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<a href="javascript:delzip('{$zipname}');">删除ZIP备份</a>
			</div>
		</div> -->
		
	</div><!--tab1-->
	
	<!-- <div class="page_btm">
	  <input type="button" onclick="closeui();" class="btn_b" value="关闭" />
	</div> -->
	</form>
</div>

</div>
<script type="text/javascript">
function delzip(zip){
	var datas = {'zipname':zip};
	$.post("__URL__/delzip", datas, zipdelResponse,'json');
}
function zipdelResponse(res){
	if(res.status == '0') {
		alert(res.info);
	}else {
		alert(res.info);
		//ui.box.close();
	}
}
function closeui(){
	ui.box.close();
}
</script>