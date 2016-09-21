$task_content_inner = null;
$mainiframe=null;
var tabwidth=119;
$loading=null;
$nav_wraper=$("#nav_wraper");

$content=$("#mycontent");
var headerheight=86;
$content.height($(window).height()-headerheight);
$nav_wraper.height($(window).height()-headerheight);

$(window).resize(function(){
    $content.height($(window).height()-headerheight);
    //calcTaskitemsWidth();
});

$task_content_inner = $("#task-content-inner");

//导航栏显示多个
$("#task-content-inner li").live("click", function () {
    openapp($(this).attr("app-url"), $(this).attr("app-id"), $(this).attr("app-name"), $(this),'1');
    return false;
});

$("#task-content-inner li").live("dblclick", function () {
    closeapp($(this));
    return false;
    
});
$("#task-content-inner li a #xclosex").live("click", function () {
    closeapp($(this).parent().parent());
    return false;
    
});

$("#task-next").click(function () {
    var marginleft = $task_content_inner.css("margin-left");
    marginleft = marginleft.replace("px", "");
    var width = $("#task-content-inner li").length * tabwidth;
    var content_width = $("#task-content").width();
    var lesswidth = content_width - width;
    marginleft = marginleft - tabwidth <= lesswidth ? lesswidth : marginleft - tabwidth;

    $task_content_inner.stop();
    
    $task_content_inner.animate({ "margin-left": marginleft + "px" }, 300, 'swing');
});
$("#task-pre").click(function () {
    var marginleft = $task_content_inner.css("margin-left");
    marginleft = parseInt(marginleft.replace("px", ""));
    marginleft = marginleft + tabwidth > 0 ? 0 : marginleft + tabwidth;
    // $task_content_inner.css("margin-left", marginleft + "px");
    $task_content_inner.stop();
    
    $task_content_inner.animate({ "margin-left": marginleft + "px" }, 300, 'swing');
});

$("#refresh_wrapper").click(function(){
    var $current_iframe=$("#mycontent iframe:visible");
    $current_iframe[0].contentWindow.location.reload();
    return false;
});

var task_item_tpl ='<li><a class="macro-tabs-item-text" href="#" title=""></a></li>';

var appiframe_tpl='<iframe style="width:100%;height: 100%;" frameborder="0" class="appiframe"></iframe>';

function openapp(url, appid, appname, selectObj,boolflag) {
    if(boolflag) boolflag = boolflag||'';
    var $app = $("#task-content-inner li[app-id='"+appid+"']");
    $("#task-content-inner .current").removeClass("current");
    
    if ($app.length == 0) {
        //添加这个的目的是为了使上方的导航栏只显示一个
        //$task_content_inner.find("li").eq(0).siblings().remove();
        
        var task = $(task_item_tpl).attr("app-id", appid).attr("app-url",url).attr("app-name",appname).addClass("current");
        //task.find(".macro-tabs-item-text").html(appname);
        task.find(".macro-tabs-item-text").html(appname+"&nbsp;&nbsp;<span id='xclosex'>X</span>");
        $task_content_inner.find('.noclose').after(task);
        //$task_content_inner.append(task);
        $(".appiframe").hide();
        $appiframe=$(appiframe_tpl).attr("src",url).attr("id","appiframe-"+appid);
        $appiframe.appendTo("#mycontent");
        calcTaskitemsWidth();
    } else {
    	$app.addClass("current");
    	$(".appiframe").hide();
    	var $iframe=$("#appiframe-"+appid);
        //点击上面的导航栏不刷新页面
        if(boolflag == 1){
            var src=$iframe.get(0).contentWindow.location.href;
            src=src.substr(src.indexOf("://")+3);
            $iframe.show();
        }else{
            $iframe.remove();
            $appiframe=$(appiframe_tpl).attr("src",url).attr("id","appiframe-"+appid);
            $appiframe.appendTo("#mycontent");
            calcTaskitemsWidth();
        }
    }

    var itemoffset= $("#task-content-inner li[app-id='"+appid+"']").index()* tabwidth;
    var width = $("#task-content-inner li").length * tabwidth;
   
    var content_width = $("#task-content").width();
    var offset=itemoffset+tabwidth-content_width;
    
    var lesswidth = content_width - width;
    
    var marginleft = $task_content_inner.css("margin-left");
   
    marginleft =parseInt( marginleft.replace("px", "") );
    var copymarginleft=marginleft;
    if(offset>0){
        marginleft=marginleft>-offset?-offset:marginleft;
    }else{
        marginleft=itemoffset+marginleft>=0?marginleft:-itemoffset;
    }
    
    if(-itemoffset==marginleft){
        marginleft = marginleft + tabwidth > 0 ? 0 : marginleft + tabwidth;
    }
    
    if(content_width-copymarginleft-tabwidth==itemoffset){
        marginleft = marginleft - tabwidth <= lesswidth ? lesswidth : marginleft - tabwidth;
    }
    $task_content_inner.animate({ "margin-left": marginleft + "px" }, 300, 'swing');

}

function calcTaskitemsWidth() {

    var width = $("#task-content-inner li").length * tabwidth;
    $("#task-content-inner").width(width);
    if (($(document).width()-268-115- 30 * 2) < width) {
        $("#task-content").width($(document).width() -268-115- 30 * 2);
        $(".qdlleft,.qdlright").show();
        $("#task-next,#task-pre").show();
    } else {
        $("#task-next,#task-pre").hide();
        $(".qdlleft,.qdlright").hide();
        $("#task-content").width(width);
    }
}

function closeapp($this){
    if(!$this.is(".noclose")){
        $this.prev().click();
        $this.remove();
        calcTaskitemsWidth();
        $("#task-next").click();
    }
     
}