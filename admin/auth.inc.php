<?php
/*array(菜单名，菜单url参数，是否显示)*/
//error_reporting(E_ALL);
/*
$auth_inc[$i]['low_leve']['global']  global是model
每个action前必须添加eqaction_前缀'eqaction_websetting'  => 'at1','at1'表示唯一标志,可独自命名,eqaction_后面跟的action必须统一小写


*/
$auth_inc =  array();
$i=0;
$auth_inc[$i]['low_title'][] = '全局设置';
$auth_inc[$i]['low_leve']['setting']= array(
	"网站设置" =>array(
		"列表" 		=> 'at1',
		"增加" 		=> 'at2',
		"删除" 		=> 'at3',
		"修改" 		=> 'at4',
	),
	"所有缓存" =>array(
		"清除" 		=> 'at22',
	),
   "data" => array(
   		//网站设置
		'eqaction_websetting'  => 'at1',
		'eqaction_doadd'       => 'at2',
		'eqaction_dodelweb'    => 'at3',
		'eqaction_doedit'      => 'at4',
   		//清除缓存
		'eqaction_cleanall'    => 'at22',
	)
);
//操作日志
$auth_inc[$i]['low_leve']['adminlogs']= array( "操作日志" =>array(
		"列表" 		=> 'adminlogs1',
		"增加" 		=> 'adminlogs2',
		"删除" 		=> 'adminlogs3',
		"修改" 		=> 'adminlogs4',
	),
   "data" => array(
   		'eqaction_index'    => 'adminlogs1',
		'eqaction_doadd'    => 'adminlogs2',
		'eqaction_add'      => 'adminlogs2',
		'eqaction_dodelete' => 'adminlogs3',
		'eqaction_doedit'   => 'adminlogs4',
		'eqaction_edit'   	=> 'adminlogs4',
	)
);
//欢迎页面
$auth_inc[$i]['low_leve']['welcome']= array( "欢迎页" =>array(
		"查看" 		=> 'wel1',
	),
   "data" => array(
   		//欢迎页
		'eqaction_index'  => 'wel1',
	)
);

//权限管理
$i++;
$auth_inc[$i]['low_title'][] = '权限管理';
$auth_inc[$i]['low_leve']['auth']= array(
	"权限管理" =>array(
		"列表" 		=> 'at73',
		"增加" 		=> 'at74',
		"删除" 		=> 'at75',
		"修改" 		=> 'at76',
	),
   "data" => array(
   		//权限管理
		'eqaction_index'    => 'at73',
		'eqaction_doadd'    => 'at74',
		'eqaction_add'      => 'at74',
		'eqaction_dodelete' => 'at75',
		'eqaction_doedit'   => 'at76',
		'eqaction_edit'   	=> 'at76',
	)
);
//管理员管理
$i++;
$auth_inc[$i]['low_title'][] = '管理员管理';
$auth_inc[$i]['low_leve']['adminuser']= array(
	"管理员管理" =>array(
		"列表" 		=> 'at77',
		"增加" 		=> 'at78',
		"删除" 		=> 'at79',
		"上传头像"	=> 'at99',
		"修改" 		=> 'at80',
	),
   	"data" => array(
   		//权限管理
		'eqaction_index'  => 'at77',
		'eqaction_dodelete'    => 'at79',
		'eqaction_header'    => 'at99',
		'eqaction_memberheaderuplad'    => 'at99',
		'eqaction_addadmin' =>array(
			'at78'=>array(//增加
				'POST'=>array(
					"uid"=>'G_NOTSET',
				),
			),
			'at80'=>array(//修改
				'POST'=>array(
					"uid"=>'G_ISSET',
				),
			),
		),
	)
);

//数据库管理
// $i++;
// $auth_inc[$i]['low_title'][] = '数据库管理';
// $auth_inc[$i]['low_leve']['db']= array(
// 	"数据库信息" =>array(
// 		"查看"		=> 'db1',
// 		"备份"		=> 'db2',
// 		"查看表结构"	=> 'db3',
// 	),
//    "数据库备份管理" =>array(
// 		"备份列表" 		=> 'db4',
// 		"删除备份" 		=> 'db5',
// 		"恢复备份" 		=> 'db6',
// 		"打包下载" 		=> 'db7',
// 	),
//    "清空数据" =>array(
// 		"清空数据"		=> 'db8',
// 	),
// 	"data" => array(
//    		//权限管理
// 		'eqaction_index'  		=> 'db1',
// 		'eqaction_set'  		=> 'db2',
// 		'eqaction_backup'  		=> 'db2',
// 		'eqaction_showtable'  	=> 'db3',
// 		'eqaction_baklist'  	=> 'db4',
// 		'eqaction_delbak'  		=> 'db5',
// 		'eqaction_restore'  	=> 'db6',
// 		'eqaction_dozip'  		=> 'db7',
// 		'eqaction_downzip'  	=> 'db7',
// 		'eqaction_truncate'  	=> 'db8',
// 	)
// );



/* End of file auth.inc.php */
/* Location: ./admin/auth.inc.php */
