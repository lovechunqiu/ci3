<script type="text/javascript" src="<?php echo static_url('static/style/My97DatePicker/WdatePicker.js');?>" language="javascript"></script>

<!-- search-->
<div id="search_div" style="display:none;">
<form class="form-horizontal" method="get" action="<?php echo site_url('adminlogs/index');?>">
  <fieldset>
    <div class="row-fluid">
      <div class="navbar">
        <div class="navbar-inner">
          <h6><?php echo $search_name;?> [ <a href="javascript:void(0);" onclick="dosearch();">隐藏</a> ]</h6>
        </div>
      </div>
      <div class="well">
        <div class="control-group">
          <label class="control-label">搜索：</label>
          <div class="controls">
            <input name="keywords" class="span4" type="text" value="<?php echo ! empty($search['keywords']) ? $search['keywords'] : '';?>">
            不填则不限制<font color="red">（可填写 手机号、描述）</font>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">添加时间(开始)：</label>
          <div class="controls">
            <input name="created_start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true});" class="span4 Wdate" type="text" value="<?php echo ! empty($search['created_start']) ? $search['created_start'] : '';?>">
            不填则不限制
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">添加时间(结束)：</label>
          <div class="controls">
            <input name="created_end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true});" class="span4 Wdate" type="text" value="<?php echo ! empty($search['created_end']) ? $search['created_end'] : '';?>">
            不填则不限制
          </div>
        </div>
        <div class="form-actions align-left">
          <input type="submit" class="btn btn-primary" value="确定" />
        </div>
      </div>
    </div>
  </fieldset>
</form>  
<div class="pubheit"></div>
</div>