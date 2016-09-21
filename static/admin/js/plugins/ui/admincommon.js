
//搜索
function dosearch(s) {
  if(isSearchHidden == 1) {
    $("#search_div").slideDown("fast");
    $(".search_action").html("搜索完毕");
    isSearchHidden = 0;
  }else {
    $("#search_div").slideUp("fast");
    $(".search_action").html(searchName);
    isSearchHidden = 1;
  }
}

function checkon(o){
    if( o.checked == true ){
        $(o).parents('tr').addClass('bg_on') ;
    }else{
        $(o).parents('tr').removeClass('bg_on') ;
    }
}

function checkAll(o){

    if( o.checked == true ){
        $('tr').find('span').addClass('checked');
        $('tr').find('input').attr('checked',true);
        $('tr').addClass("bg_on");
    }else{
        $('tr').find('span').removeClass('checked');
        $('tr').find('input').attr('checked',false);
        $('tr').removeClass("bg_on");
    }
}

//删除及影响
function del(aid, url) {

    aid = aid ? aid : getChecked();
    aid = aid.toString();
    if(aid == '' || aid == '0,0'){
        tanDialog('至少选择一项');return false;
    }

    if(url){
        var content = '确定要恢复吗?';
    }else{
        var content = '删除后不可恢复，确定要删除吗?';
    }

    top.dialog({
        title   : '消息',
        content : content,
        id      : 'dd',
        zIndex  : 1100,
        button  : [
            {
              value: '同意',
              callback: function () {
                delResponse(aid, url);
              },
              autofocus: true
            },
            {
              value: '取消'
            }
        ]
    }).showModal();
    
}

function delResponse(aid, url){

    if(url){
        delUrl = url;
    }

    //提交修改
    var datas = {'idarr':aid};
    $.post(delUrl, datas,function(res1){
        var res = eval("("+res1+")");
        if(res.status == '0') {
            tanDialog(res.info);
        }else {
            tanDialog(res.info);
            setTimeout(function () {
                window.location.reload();
            }, 1000);
        }
    });
}   
//删除及影响--------------END----------

//获取已选择用户的ID数组
function getChecked() {
    var gids = new Array();
    $.each($('input:checked'), function(i, n){
        var v = $(n).val();
        if(v != 0){
            gids.push( $(n).val() );
        }
    });
    return gids;
}

//跳转
function loadUser(id,uname){
    //ui.box.load("/admin/common/member?id="+id, {title:uname+" ->的详细信息"});
	showDialog("/admin/common/member?id="+id, uname+" ->的详细信息");
}
//ajax添加
function add(){
    showDialog(addUrl, addTitle);
}
//ajax编辑
function edit(url_arg){
    showDialog(editUrl+url_arg, editTitle);
}

function loadTixian(id,uname){
    showDialog("/admin/withdrawlog/edit?id="+id, uname+" ->的编辑信息");
}
function loadTixianwait(id,uname){
    showDialog("/admin/withdrawlogwait/edit?id="+id, uname+" ->的编辑信息");
}
function loadTixianing(id,uname){
    showDialog("/admin/withdrawloging/edit?id="+id, uname+" ->的编辑信息");
}

//跳转
function goto(url){
	window.location.href=url;
}

//tab切换
$(".page_tab li").bind("click", function(){
	var tab = $(".page_tab li");
	$.each(tab, function(i,n){
		var tid = $(n).attr('data');
		$(n).removeClass('active');
		$("#"+tid).hide();
	});
	var current = $(this).attr('data');
	$(this).addClass('active');
	$("#"+current).show();
});

//tab切换
$(".page_tab span").bind("click", function(){
    var tab = $(".page_tab span");
    $.each(tab, function(i,n){
        var tid = $(n).attr('data');
        $(n).removeClass('active');
        $("#"+tid).hide();
    });
    var current = $(this).attr('data');
    $(this).addClass('active');
    $("#"+current).show();
}); 

/**
 * 公共弹出框
 * @param  {[type]} url      [description]
 * @param  {[type]} Title    [description]
 * @param  {[type]} sendType [description]
 * @param  {[type]} sendData [description]
 * @return {[type]}          [description]
 */
function showDialog(url,Title,sendType,sendData){
    var sendType=sendType||"GET";
    var sendData=sendData||" ";
    $.ajax({
        url:url,
        type:sendType,
        dataType:'html',
        data:sendData,
        cache: false,
        success:function(html){
            var d = top.dialog({
                title:Title,
                content:html,
                id:'dd',
                zIndex: 1100
            });
            d.__lock();    //锁屏
            d.__center();  //弹出框的方式，从中间显示
            d.show();
        }
    });
}
/**
 * 关闭提交数据，并且关闭窗口，并且刷新本页面
 * @param  {[type]} url      [description]
 * @param  {[type]} type     [description]
 * @param  {[type]} datatype [description]
 * @param  {[type]} pata     [description]
 * @return {[type]}          [description]
 */
function closeDialog(url,type,datatype,pata){
    var type=type||"POST";
    var datatype=datatype||'json';
    var pata=pata||"{}";
    $.ajax({
        url:url,
        type:type,
        dateType:datatype,
        data:pata,
        async:true,
        success:function(data){
            var json = eval("("+data+")");
            if(json.status == 'success'){
                var d = dialog({
                    id:'dd'
                }).close().remove();
                var $current_iframe=$("#mycontent iframe:visible");
                $current_iframe[0].contentWindow.location.reload();
            }else{
                var str = '&nbsp;操作失败！';
                $("#cgld").empty().html(str);
            }
        }
    });
}

/**
 * 校验身份信息的弹框
 * @param  {[type]} url    [description]
 * @param  {[type]} id     [description]
 * @param  {[type]} uname  [description]
 * @param  {[type]} name   [description]
 * @param  {[type]} idcard [description]
 * @param  {[type]} title  [description]
 * @param  {[type]} obj    [description]
 * @return {[type]}        [description]
 */
function checkCertId(url,id, uname,name, idcard, title,obj){
  top.dialog({
    title:'警告',
    content:'功能正在测试阶段，具体请联系智慧云联',
    id:'dd',
    zIndex: 1100,
    button: [
        {
          value: '同意',
          callback: function () {
            posdatas(url,id, uname,name, idcard, title,obj);
          },
          autofocus: true
        },
        {
          value: '取消'
        }
    ]
  }).showModal();
  
}
/**
 * 校验身份信息发送数据
 * @param  {[type]} url    [description]
 * @param  {[type]} id     [description]
 * @param  {[type]} uname  [description]
 * @param  {[type]} name   [description]
 * @param  {[type]} idcard [description]
 * @param  {[type]} title  [description]
 * @param  {[type]} obj    [description]
 * @return {[type]}        [description]
 */
function posdatas(url,id, uname,name, idcard, title,obj){

    var data = {};
    data.id = id;
    data.uname = uname;
    data.real_name = name;
    data.idcard = idcard;
    $.ajax({
      type: "POST",
      url : url,
      data: data,
      async:true,
      beforeSend:function(){
        $(obj).html('校验中');
      },
      success: function(msg){
        var json = eval('('+msg+')');
        if(json.code == '200'){
          $(obj).removeAttr('onclick');
          $(obj).css('color', '#00CC00');
          $(obj).html('正确');
        } else{
          $(obj).css('color', 'red');
          $(obj).html('不正确');
        }
        
        var d = top.dialog({
            id:'dd',
            content:json.info,
            title:'消息'
        }).show();
      },
      error:function(){
        $(obj).html(title);
      },
      complete:function(){
        //$(obj).html(title);
      }
    });
}

/**
 * dialog 弹出信息,如果不点击关闭，那么2秒钟之后自动关闭
 * @param  {[type]} msg [description]
 * @return {[type]}     [description]
 */
function tanDialog(msg, time){
    if(!time)
        time = 2000;
    var d = top.dialog({
        id:'dd',
        content:msg,
        title:'消息'
    }).show();
    setTimeout(function () {
        d.close().remove();
    }, time);
}

/**
 * 单纯的弹框
 * @param msg
 * @returns
 */
function smsDialog(msg){
    var d = dialog({
        id:'dd1',
        content:msg,
        title:'消息'
    }).show();
    setTimeout(function () {
        d.close().remove();
    }, 2000);
}

/**
* 提交数据
* @author lideqiang@cxshiguang.com
* @date   2016-04-05
* @param  {[type]}   url  [description]
* @param  {[type]}   pata [description]
* @return {[type]}        [description]
*/
window.submiting = false;
function send_data(url, pata){
    $.ajax({
        url      : url,
        type     : "post",
        dataType : "json",
        async    : true,
        data     : pata,
        beforeSend: function(){
            $('#showwait').val('提交中...').attr('disabled', 'disabled');
            window.submiting = true;
        },
        success: function(data) {
            $('#showwait').val('提交').attr('disabled', false);
            window.submiting = false;
            //console.log(data.info);return
            alert(data.info);
            if(data.status == 1){
            window.location.href=document.referrer;
            }else{

            }
        },
        error:function(){
            $('#showwait').val('提交').attr('disabled', false);
            window.submiting = false;
        },
        complete:function(){
            $('#showwait').val('提交').attr('disabled', false);
            window.submiting = false;
        }
    });
}
