<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台首页
 * @author: lideqiang87@gmail.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */
class Home extends MY_Controller {

    var $justlogin = true;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('madmin', 'madmin_auth'));
    }

    /**
     * 首页
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    public function index(){

        require("./auth.inc.php");
        require("./menu.inc.php");

        //获取相应管理员下的权限分配
        $aid = $this->session->userdata('admin');
        $aid = ! empty($aid) ? $aid : 0;
        $admin_info = check_admin($aid);
        $user_group_id = $admin_info['user_group_id'];

        $al = get_group_data($user_group_id);
        $auth = $al['controller'];
        $submenu = F('submenu_' . $user_group_id);
        if( ! $submenu){
            $submenu = array();
            //dump($auth);die;
            foreach ($menu_left as $key => $value) {
                if($value[2]==0) continue;
                $submenu[$key.'one']['icon'] = '';
                $submenu[$key.'one']['id'] = $key.'one';
                $submenu[$key.'one']['name'] = $value[0];
                $submenu[$key.'one']['url'] = $value[1];
                if(isset($value['low_title']) && !empty($value['low_title'])){
                    foreach ($value['low_title'] as $k => $val) {
                        if($val[2]==0) continue;
                        $submenu[$key.'one']['items'][$k.'two'.$key]['icon'] = '';
                        $submenu[$key.'one']['items'][$k.'two'.$key]['id'] = $k.'two'.$key;
                        $submenu[$key.'one']['items'][$k.'two'.$key]['name'] = $val[0];
                        $submenu[$key.'one']['items'][$k.'two'.$key]['url'] = $val[1];
                        if(isset($value[$k]) && !empty($value[$k])){
                            foreach ($value[$k] as $n => $v) {
                                if($v[2]==0) continue;
                                if(isset($auth[strtolower($v[3])]) && in_array($v[4],$auth[strtolower($v[3])])){
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['icon'] = '';
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['id'] = $n.$k.'three'.$key;
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['name'] = $v[0];
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['url'] = $v[1];
                                }
                            }
                        }
                    }
                }
            }
            
            //遍历数据
            foreach($submenu as $key=>$value){
                foreach ($value['items'] as $k => $v) {
                    if(empty($v['items'])){
                        unset($submenu[$key]['items'][$k]); 
                    }
                }
            }
            foreach ($submenu as $key => $value) {
                if(empty($value['items'])){
                    unset($submenu[$key]);  
                }
            }
            F('submenu_'.$user_group_id, $submenu);
        }
        //$this->_return('home/home', array('submenu' => $submenu));
        
        $this->load->vars(array('submenu' => $submenu));
        $this->load->view('home/home');
    }

    /**
     * 登陆
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    public function login(){

        if($_POST){
            $this->load->library(array('SktMemcached'));
            $post = $this->data;
            $jumpurl = site_url('home/logout');
            $timeout = 1;
            //参数校验，通用方法，校验参数不能为空
            $flag = admin_check_params($post, array('admin_name', 'admin_pass', 'captcha'));
            if($flag){
                $this->error('参数' . $flag . '不能为空', $jumpurl, $timeout);
            }
            
            //检测验证码
            $c_code = $this->_check_code($post['captcha']);
            if($c_code){
                $this->error('验证码不正确', $jumpurl, $timeout);
            }

            $name = $post['admin_name'];
            $pass = $post['admin_pass'];
            //$word = $post['user_word'];
            $code = $post['captcha'];
            //$pode = $post['phone_code'];

            $condition = array(
                'status'    => 1,
                'user_name' => $name
            );
            $info = $this->madmin->get_one($condition);
            if(empty($info)){
                $this->error('用户名不正确', $jumpurl, $timeout);
            }
            if($info['user_pass'] != md5($pass)){
                $this->error('密码不正确', $jumpurl, $timeout);
            }
            // if($info['user_word'] != $word){
            //     $this->error('密码口令不正确', $jumpurl, $timeout);
            // }
            // if($pode != 111111){
            //     $this->error('随机码不正确', $jumpurl, $timeout);
            // }

            $admin_auth = $this->madmin_auth->geto($info['user_group_id']);
            $session_data = array(
                'admin'         => $info['id'],
                'apid'          => $info['pid'],
                'adminname'     => $info['user_name'],
                'realname'      => $info['real_name'],
                'user_group_id' => $info['user_group_id'],
                'groupname'     => $admin_auth['groupname'],
            );
            //登陆成功，将参数存入session
            $this->session->set_userdata($session_data);
            alogs(0, 0, $info['user_name'] . '登陆后台成功');
            $this->success('登陆成功', site_url('home/index'), $timeout);
        }else{
            $this->load->view('home/login');
        }
    }

    /**
     * 登陆检测
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function logincheck(){

        $c_code = $this->input->get('code', TRUE);
        
        if(isset($c_code) && $c_code != 'admin'){
            $this->error("非法请求", site_url('home/login'));
        }else{
            redirect('home/login');
        }
        
    }

    /**
     * 退出
     * @author lideqiang@cxshiguang.com
     * @date   2015-09-28
     * @return [type]     [description]
     */
    public function logout()
    {
        //清空缓存
        $data = array(
            'admin'         => '',
            'adminname'     => '',
            'user_group_id' => '',
            'teacher_id'    => ''
        );
        $na = $this->session->userdata('adminname');
        alogs(0, 0, $na . '退出后台成功');
        $this->session->unset_userdata($data);
        redirect('home/login');
    }

    /**
     * 修改密码
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function editpass(){
        $this->_return('home/editpass');
    }

    /**
     * 检测修改密码
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function checkpass(){

        $aid = $this->session->userdata('admin');
        $oldpass = trim($_POST['oldpass']);
        $newpass = trim($_POST['newpass']);
        $newpass1 = trim($_POST['newpass1']);
        $oldword = trim($_POST['oldword']);
        $newword = trim($_POST['newword']);
        $newword1 = trim($_POST['newword1']);
        $type = trim($_POST['type']);
        
        if(!$oldpass){
            $this->callback_json(0,'原密码不能为空');
        }
        if(!$oldword){
            $this->callback_json(0,'原口令不能为空');
        }
        if($newpass != $newpass1){
            $this->callback_json(0,'原密码和新密码不一致');
        }
        if($newword != $newword1){
            $this->callback_json(0,'原口令和新口令不一致');
        }
        if(!$newpass && !$newword){
            $this->callback_json(0,'密码或者口令不能为空');
        }
        //检验原密码是否正确
        $data['id'] = $aid;
        $data['user_pass'] = md5($oldpass);
        $r1 = $this->madmin->get_one($data);
        if(!$r1){
            $this->callback_json(0,'原密码不正确');
        }
        //判断是否有口令
        if($r1['user_word'] != $oldword){
            $this->callback_json(0,'原口令不正确');
        }
        
        if($newpass) $pata['user_pass'] = md5($newpass);
        if($newword) $pata['user_word'] = $newword;
        $r3 = $this->madmin->update($aid, $pata);
        if($r3){
            $this->callback_json(1,'密码修改成功');
        }else{
            $this->callback_json(0,'密码修改失败');
        }
    }

    /**
     * 修改手机号
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function editphone(){
        $this->_return('home/editphone');
    }

    /**
     * 检测手机号
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    function checkphone(){
        $aid = $this->session->userdata('admin');
        $post = $this->data;
        $phone = trim($post['phone']);
        $rule = "/^((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}$/A";
        
        if(!$phone){
            $this->callback_json(0,'手机号不能为空');
        }
        if(!preg_match($rule,$phone)){
            $this->callback_json(0,'手机号格式不正确');
        }
        
        $data['mobile'] = $phone;
        $r = $this->madmin->update($aid, $data);
        if($r){
            $this->callback_json(1,'手机号修改成功');
        }else{
            $this->callback_json(0,'手机号修改失败');
        }
        
    }

    /**
     * 检测验证码
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-28
     * @param  [type]     $code [description]
     * @return [type]           [description]
     */
    private function _check_code($code){
        $session_id = $this->session->userdata('session_id');
        $captcha = $this->session->userdata('captcha' . $session_id);
        if ((strtolower($code) == $captcha) && ($captcha != '')) {
            return FALSE;
        } else {
            $this->session->unset_userdata('captcha');
            return TRUE;
        }
    }
    
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
