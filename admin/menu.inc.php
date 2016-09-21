<?php
/*array(菜单名，菜单url参数，是否显示)*/
$i=0;
$j=0;
$menu_left =  array();
$menu_left[$i]=array('全局','#',1);
$menu_left[$i]['low_title'][$i."-".$j] = array('全局设置','#',1);
$menu_left[$i][$i."-".$j][] = array('欢迎页',site_url('welcome/index'),1,'welcome','wel1');
$menu_left[$i][$i."-".$j][] = array('网站管理',site_url('setting/websetting'),1,'setting','at1');
$menu_left[$i][$i."-".$j][] = array('操作日志',site_url('adminlogs/index'),1,'adminlogs','adminlogs1');
$j++;
$menu_left[$i]['low_title'][$i."-".$j] = array('缓存管理','#',1);
$menu_left[$i][$i."-".$j][] = array('所有缓存',site_url('setting/cleanall'),1,'setting','at22');

$i++;
$menu_left[$i]= array('权限','#',1);
$menu_left[$i]['low_title'][$i."-".$j] = array('用户权限管理',"#",1);
$menu_left[$i][$i."-".$j][] = array('管理员管理',site_url('adminuser/index'),1,'adminuser','at77');
$menu_left[$i][$i."-".$j][] = array('用户组权限管理',site_url('auth/index'),1,'auth','at73');

// $i++;
// $menu_left[$i]= array('数据库','#',1);
// $menu_left[$i]['low_title'][$i."-".$j] = array('数据库管理','#',1);
// $menu_left[$i][$i."-".$j][] = array('数据库信息',site_url('db/index'),1,'Db','db1');
// $menu_left[$i][$i."-".$j][] = array('备份管理',site_url('db/baklist'),1,'Db','db4');



?>
