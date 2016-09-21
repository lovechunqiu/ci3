
<form class="form-horizontal" method="post" onsubmit="return subcheck();">
	<fieldset>
		<div class="widget row-fluid" style="width:600px;">
			<div class="well">
				<input type="hidden" id="baktable" name="baktable" value="<?php echo implode(',', $tables);?>"/>
				<div id="tab_1">
					<div class="control-group">
						<label class="control-label">备份目录名称：</label>
						<div class="controls">
							<input name="savepath" id="savepath" class="input" type="text" value="">
							<span id="tip_savepath" class="tip"> 不能是中文,目录名相同会覆盖</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">备份备注：</label>
						<div class="controls">
							<input name="info" id="info" class="input" type="text" value="">
							<span id="tip_info" class="tip"> 会在备份目录下生成txt保存备注</span>
						</div>
					</div>
				</div><!--tab1-->
				
				<div class="form-actions align-left">
				  <input type="button" onclick="subcheck();" class="btn btn-primary" value="开始" />
				</div>
			</div>
		</div>
	</fieldset>
</form>

<script>

//提交数据
function subcheck(){
	var savepath = $("#savepath").val();
	var info = $("#info").val();
	var baktable = $("#baktable").val();
	
	var url = "<?php echo site_url('db/backup');?>";
	var pata = {savepath:savepath,info:info,baktable:baktable};
	
	//提交数据，并且关闭窗口，并且刷新页面
	closeDialog(url,'POST','json',pata);
}
</script>
