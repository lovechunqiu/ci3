<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 得到文件大小
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $size [description]
 * @return [type]           [description]
 */
function getMb($size){
	$mbsize=$size/1024/1024;
	if($mbsize>0)
	{
		if($size % 1024 != 0){
			list($t1,$t2)=explode(".",$mbsize);
			$mbsize=$t1.".".substr($t2,0,2);
		}
	}
	if($mbsize<1){
		$kbsize=$size/1024;
		if($size % 1024 != 0){
			list($t1,$t2)=explode(".",$kbsize);
			$kbsize=$t1.".".substr($t2,0,2);
		}
		return $kbsize."KB";
	}else{
		return "<span style='color:blue'>".$mbsize."MB</span>";
	}
}

/**
 * 取得文件内容
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $filepath [description]
 */
function ReadFiletext($filepath){
	$htmlfp=@fopen($filepath,"r");
	$string = '';
	while($data=@fread($htmlfp,1000))
	{
		$string .= $data;
	}
	@fclose($htmlfp);
	return $string;
}

/**
 * 校验参数不能为空,但是不能检测为0，因为有些参数是可以赋值为0的
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  array      $data   [description]
 * @param  array      $params [description]
 * @return [type]             [description]
 */
function admin_check_params($data = array(), $params = array()){
    if(empty($data)){
        return array();
    }
    foreach($params as $key => $value){
        if(empty($data[$value])){
        	return $value;
        	break;
        }
    }
    return FALSE;
}

/**
 * 获取用户权限数组
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  string     $id [description]
 * @return [type]         [description]
 */
function get_user_auth($id=""){
	$model=strtolower(MODULE_NAME);
	
	if(empty($id)) return false;
	$info = check_admin($id);
	
	$al = get_group_data($info['user_group_id']);
	$auth = $al['controller'];
	$auth_key = auth_get_key();
	if( ! empty($auth_key) && ! empty($auth[$model]) && array_keys($auth[$model],$auth_key)) return true;
	else return false;
}

/**
 * 获取权限列表
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  integer    $gid [description]
 * @return [type]          [description]
 */
function get_group_data($gid=0){
    $gid=intval($gid);
    $list=array();

    $_CI =& get_instance();
    $_CI->load->model('madmin_auth');

    $_CI->load->driver('cache', array('adapter' => 'file'));

    if($gid == 0){
        if( ! $_CI->cache->get('AUTH_all')){
            $_auth_data = $_CI->madmin_auth->query(array('status' => 1));
            $auth_data=array();

            foreach($_auth_data as $key => $v){
                $auth_data[$v['id']] = $v;
                $auth_data[$v['id']]['controller'] = unserialize($v['controller']);
            }

            $_CI->cache->save('AUTH_all', $auth_data, 3600);
            $list = $auth_data;
        }else{
            $list = $_CI->cache->get('AUTH_all');
        }
    }else{
        if( ! $_CI->cache->get('AUTH_' . $gid)){
            $_auth_data = $_CI->madmin_auth->geto($gid);
            $_auth_data['controller'] = unserialize($_auth_data['controller']);
            $auth_data = $_auth_data;
            $_CI->cache->save('AUTH_' . $gid, $auth_data, 3600);
            $list = $auth_data;
        }else{
            $list = $_CI->cache->get('AUTH_' . $gid);
        }
    }
    return $list;
}

/**
 * 获取权限key值
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @return [type]     [description]
 */
function  auth_get_key(){

	empty($model)?$model=strtolower(MODULE_NAME):$model=strtolower($model);
	empty($action)?$action=strtolower(ACTION_NAME):$action=strtolower($action);

	$keys = array($model,'data','eqaction_'.$action);
	require "./auth.inc.php";
	$inc = $auth_inc;
	
	$array = array();
	foreach($inc as $key => $v){
		if(isset($v['low_leve'][$model])){
			$array = $v['low_leve'];
			continue;
		}
	}//找到auth.inc中对当前模块的定义的数组
	
	$num = count($keys);
	$num_last = $num - 1;
	$this_array_0 = &$array;
	$last_key = $keys[$num_last];
	
	for ($i = 0; $i < $num_last; $i++){
		$this_key = $keys[$i];
		$this_var_name = 'this_array_' . $i;
		$next_var_name = 'this_array_' . ($i + 1);        
		if (!array_key_exists($this_key, $$this_var_name)) {            
			break;       
		}        
		$$next_var_name = &${$this_var_name}[$this_key];    
	}    

	/*取得条件下的数组  ${$next_var_name}得到data数组 $last_key即$keys = array($model,'data','eqaction_'.$action);里面的'eqaction_'.$action,所以总的组成就是，在auth.inc数组里找到键为$model的数组里的键为data的数组里的键为'eqaction_'.$action的值;*/
	$actions = isset(${$next_var_name}[$last_key]) ? ${$next_var_name}[$last_key] : NULL;//这个值即为当前action的别名,然后用别名与用户的权限比对,如果是带有参数的条件则$actions是数组，数组里有相关的参数限制
	
	if(is_array($actions)){
		foreach($actions as $key_s => $v_s){
			$ma = true;
			if(isset($v_s['POST'])){
				foreach($v_s['POST'] as $pkey => $pv){
					switch($pv){
						case 'G_EMPTY';//必须为空
							if( isset($_POST[$pkey]) && !empty($_POST[$pkey]) ) $ma = false;
						break;
					
						case 'G_NOTSET';//不能设置
							if( isset($_POST[$pkey]) ) $ma = false;
						break;
					
						case 'G_ISSET';//必须设置
							if( !isset($_POST[$pkey]) ) $ma = false;
						break;
					
						default;//默认
							if( !isset($_POST[$pkey]) || strtolower($_POST[$pkey]) != strtolower($pv) ) $ma = false;
						break;
					}
				}
			}
			
			if(isset($v_s['GET'])){
				foreach($v_s['GET'] as $pkey => $pv){
					switch($pv){
						case 'G_EMPTY';//必须为空
							if( isset($_GET[$pkey]) && !empty($_GET[$pkey]) ) $ma = false;
						break;
					
						case 'G_NOTSET';//不能设置
							if( isset($_GET[$pkey]) ) $ma = false;
						break;
					
						case 'G_ISSET';//必须设置
							if( !isset($_GET[$pkey]) ) $ma = false;
						break;
					
						default;//默认
							if( !isset($_GET[$pkey]) || strtolower($_GET[$pkey]) != strtolower($pv) ) $ma = false;
						break;
					}
					
				}
			}
			if($ma)	return $key_s;
			else $actions="0";
		}//foreach
	}else{
		return $actions;
	}
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $name  [description]
 * @param  string     $value [description]
 * @param  [type]     $path  [description]
 */
function F($name, $value='', $path=DATA_PATH) {
    static $_cache = array();
    $filename = $path . $name . '.php';

    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return unlink($filename);
        } else {
            // 缓存数据
            $dir = dirname($filename);
            // 目录不存在则创建
            if ( ! is_dir($dir))
                mkdir($dir);
            $_cache[$name] = $value;
            return file_put_contents($filename, strip_whitespace("<?php\nreturn " . var_export($value, true) . ";\n?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    } else {
        $value = false;
    }
    return $value;
}

/**
 * 去除代码中的空白和注释
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $content [description]
 * @return [type]              [description]
 */
function strip_whitespace($content) {
    $stripStr = '';
    //分析php源码
    $tokens = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
        if (is_string($tokens[$i])) {
            $last_space = false;
            $stripStr .= $tokens[$i];
        } else {
            switch ($tokens[$i][0]) {
                //过滤各种PHP注释
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                //过滤空格
                case T_WHITESPACE:
                    if (!$last_space) {
                        $stripStr .= ' ';
                        $last_space = true;
                    }
                    break;
                case T_START_HEREDOC:
                    $stripStr .= "<<<THINK\n";
                    break;
                case T_END_HEREDOC:
                    $stripStr .= "THINK;\n";
                    for($k = $i+1; $k < $j; $k++) {
                        if(is_string($tokens[$k]) && $tokens[$k] == ';') {
                            $i = $k;
                            break;
                        } else if($tokens[$k][0] == T_CLOSE_TAG) {
                            break;
                        }
                    }
                    break;
                default:
                    $last_space = false;
                    $stripStr .= $tokens[$i][1];
            }
        }
    }
    return $stripStr;
}

/**
 * 删除文件夹并重建文件夹
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $path [description]
 * @return [type]           [description]
 */
function rmdirr($path) {
    if (file_exists($path)){
        if(is_file($path)){
            if(!@unlink($path)){
                $show.="$path,";
            }
        }else{
            $handle = opendir($path);
            while (($file = readdir($handle))!='') {
                if (($file!=".") && ($file!="..") && ($file!="")){
                    if (is_dir("$path/$file")){
                        $show.=rmdirr("$path/$file");
                    } else{
                        if( !@unlink("$path/$file") ){
                            $show.="$path/$file,";
                        }
                    }
                }
            }
            closedir($handle);

            if(!@rmdir($path)){
                $show.="$path,";
            }
        }
    }
    // return $show;
}





















