
<div class="pubheit"></div>
<h5 class="widget-name"><i class="icon-text-height"></i>添加导航菜单</h5>
<form class="form-horizontal" method="post" action="">
	<fieldset>
		<div class="widget row-fluid" style="width:600px;">
			<div class="well">
				<div id="tab_1">
					<?php foreach($tablecontent as $key => $value):?>
						<div class="control-group">
							<label class="control-label"><?php echo $value['Field'];?></label>
							<div class="controls">
								类型=<?php echo $value['Type'];?>
							</div>
						</div>
					<?php endforeach;?>
					<!-- <div class="form-actions align-left">
						<input type="button" class="btn btn-primary" onclick="closeui();" value="关闭">
					</div> -->
				</div>
			</div>
		</div>
	</fieldset>
</form>
