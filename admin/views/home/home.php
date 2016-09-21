 <?php $this->view('home/header');?>
    <script>
//全局变量
var GV = {
    HOST:"<?php echo $_SERVER['HTTP_HOST'];?>",
    DIMAUB: "/",
    JS_ROOT: "static/admin/js/",
    TOKEN: ""
};

/**
 * 修改密码
 * @return {[type]} [description]
 */
function editpass(){
    dialog({
        title:'修改密码',
        width:555,
        url:"<?php echo site_url('home/editpass');?>",
        id:'dd',
        zIndex: 1100
    }).showModal();
}

/**
 * 修改手机号
 */
function editphone(){
    dialog({
        title:'修改手机号',
        width:555,
        url:"<?php echo site_url('home/editphone');?>",
        id:'dd',
        zIndex: 1100
    }).showModal();
}

</script>

<?php function getsubmenu($submenus){?>
    <?php foreach($submenus as $key => $menu){ ?>
        <li>
            <?php if(empty($menu['items'])){?>
                <a href="javascript:openapp('<?php echo $menu['url'];?>','<?php echo $menu['id'];?>','<?php echo $menu['name'];?>');">
                    <i class="icon-indent-right"></i>
                    <span class="menu-text"><?php echo $menu['name'];?></span>
                </a>
            <?php }else{?>
                <a href="#" title="" class="expand"><i class="icon-indent-right"></i><?php echo $menu['name'];?><strong><?php echo count($menu['items']);?></strong></a>
                <ul>
                    <?php getsubmenu1((array)$menu['items'])?>
                </ul>   
            <?php }?>
            
        </li>
        
    <?php }?>
<?php }?>

<?php function getsubmenu1($submenus){?>
    <?php foreach($submenus as $menu){?>
        <li>
            <?php if(empty($menu['items'])){?>
                <a href="javascript:openapp('<?php echo $menu['url'];?>','<?php echo $menu['id'];?>','<?php echo $menu['name'];?>');">
                    <i class="fa fa-angle-double-right"></i>
                    <span class="menu-text"><?php echo $menu['name'];?></span>
                </a>
            <?php }else{?>
                <a href="#" title="" class="expand"><?php echo $menu['name'];?></a>
                <ul >
                    <?php getsubmenu2((array)$menu['items'])?>
                </ul>   
            <?php }?>
            
        </li>
        
    <?php }?>
<?php }?>

<?php function getsubmenu2($submenus){?>
    <?php foreach($submenus as $menu){?>
        <li>
            <a href="javascript:openapp('<?php echo $menu['url'];?>','<?php echo $menu['id'];?>','<?php echo $menu['name'];?>');">
                <?php echo $menu['name'];?>
            </a>
        </li>
        
    <?php }?>
<?php }?>

    <!-- Fixed top -->
    <div id="top">
        <div class="fixed">
            <!-- <a href="<?php echo site_url();?>" title="" class="logo"><img src="<?php echo static_url("static/admin/img/logo.png");?>" alt="" /></a> -->
            <a href="<?php echo site_url();?>" title="" class="logo">管理后台</a>
            <ul class="top-menu">
                <li><a class="fullview"></a></li>
                <li id="refresh_wrapper"><a class="showmenu" title="刷新当前页"></a></li>
                <li class="dropdown">
                    <a class="user-menu" data-toggle="dropdown"><span><?php echo $this->session->userdata('groupname');?> <?php echo $adminname;?><b class="caret"></b></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" onclick="editpass();" title=""><i class="icon-cog"></i>修改密码</a></li>
                        <li><a href="javascript:void(0);" onclick="editphone();" title=""><i class="icon-cog"></i>修改手机号</a></li>
                        <li><a href="<?php echo site_url('home/logout');?>" title=""><i class="icon-remove"></i>退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /fixed top -->

    <!-- Content container -->
    <div id="container">

        <!-- Sidebar 左侧的菜单栏-->
        <div id="sidebar">

            <div class="sidebar-tabs">
                <ul class="tabs-nav two-items">
                    <li><a href="#general" title=""><i class="icon-reorder"></i></a></li>
                    <li><a href="#stuff" title=""><i class="icon-cogs"></i></a></li>
                </ul>

                <div id="general">
                    <!-- <div class="general-stats widget">
                        <ul class="head">
                            <li><span>会员数</span></li>
                            <li><span>贷款数</span></li>
                            <li><span>资金量</span></li>
                        </ul>
                        <ul class="body">
                            <li><strong>9999</strong></li>
                            <li><strong>8888</strong></li>
                            <li><strong>5555</strong></li>
                        </ul>
                    </div> -->
                    <!-- Main navigation -->
                    <div id="nav_wraper">
                        <ul class="navigation widget">
                            <?php echo getsubmenu($submenu)?>
                        </ul>
                    </div>
                    <!-- /main navigation -->

                </div>

            </div>
        </div>
        <!-- /sidebar -->

        <!-- Content -->
        <div id="content">
            <div class="wrapper">

                <!-- Breadcrumbs line -->
                <div class="crumbs">
                    
                    <!--向左移动-->
                    <span class="qdlleft"><a id="task-pre" class="task-changebt">←</a></span>
                    <div id="task-content">
                        <ul id="task-content-inner" class="breadcrumb"> 
                            <li app-id="0" app-name="首页" app-url="<?php echo site_url('main/index');?>" class="noclose"><a href="#" title=""><span>首页</span></a></li>
                        </ul>
                    </div>
                    <!--向右移动-->
                    <span class="qdlright"><a id="task-next" class="task-changebt">→</a></span>
                    
                </div>
                <!-- /breadcrumbs line -->
                <div id="mycontent" style="height:700px;">
                    <iframe src="<?php echo site_url('welcome/index');?>" style="width:100%;height:100%;" frameborder="0" id="appiframe-0" class="appiframe"></iframe>
                </div>
            </div>
        </div>
        <!-- /content -->
    </div>
    <!-- /content container -->

</body>
</html>

<script type="text/javascript" src="<?php echo static_url('static/admin/js/plugins/ui/index.js');?>"></script>
    