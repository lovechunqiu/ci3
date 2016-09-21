<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * var_dump
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $data [description]
 * @return [type]           [description]
 */
function dump($data){
    echo '<pre>';
    echo '<meta charset = "utf-8">';
    var_dump($data);
    echo '</pre>';
}

/**
 * 检测后台管理员是否存在
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $admin_id [description]
 * @return [type]               [description]
 */
function check_admin($admin_id){
    $_CI =& get_instance();
    // $_CI->load->library('SktMemcached');
    // $mkey = 'skt:admin_info_' . $admin_id;
    // if($data = $_CI->sktmemcached->get($mkey)){
    //     return $data;
    // }
    $_CI->load->model('madmin');
    //查询班级是否存在
    $data = $_CI->madmin->geto($admin_id);
    if( ! $data){
        return_json(0, '', '后台管理员不存在，请重新选择');
    }
    // $_CI->sktmemcached->set($mkey, $data, C('skt_config.mem_time'));
    return $data;
}

/**
 * 查询后台管理员权限
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $admin_auth_id [description]
 * @return [type]                    [description]
 */
function check_admin_auth($admin_auth_id){
    $_CI =& get_instance();
    // $_CI->load->library('SktMemcached');
    // $mkey = 'skt:admin_auth_info_' . $admin_auth_id;
    // if($data = $_CI->sktmemcached->get($mkey)){
    //     return $data;
    // }
    $_CI->load->model('madmin_auth');
    //查询班级是否存在
    $data = $_CI->madmin_auth->geto($admin_auth_id);
    if( ! $data){
        return_json(0, '', '后台管理员权限信息不存在，请重新选择');
    }
    // $_CI->sktmemcached->set($mkey, $data, C('skt_config.mem_time'));
    return $data;
}

/**
 * 后台管理员操作日志
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @param  [type]     $type   [description]
 * @param  integer    $tid    [description]
 * @param  string     $desc   [description]
 * @param  string     $user   [description]
 * @param  string     $mobile [description]
 * @return [type]             [description]
 */
function alogs($type, $tid = 0, $desc = '', $user = '', $mobile = ''){
    $_CI = & get_instance();
    $_CI->load->model(array('madmin_logs', 'madmin'));
    if(empty($mobile)){
        $aid  = $_CI->session->userdata('admin');
        $info = $_CI->madmin->geto($aid);
    }
    $arr  = array();
    $arr['aid']  = ! empty($info) ? $info['id'] : 0;
    $arr['name'] = $user ? $user : ( ! empty($info) ? ($info['user_name'] . '(' . $info['real_name'] . ')') : '');
    if( ! empty($mobile))
        $arr['mobile'] = $mobile;
    $arr['desc'] = $desc;
    $arr['ip']   = get_client_ip();
    $arr['type'] = $type;
    $arr['tid']  = ! empty($tid) ? $tid : 0;
    $result      = $_CI->madmin_logs->add($arr);
    return $result;
}

/**
 * 获取客户端IP地址
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @return [type]     [description]
 */
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL) return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos =  array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip   =  trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

