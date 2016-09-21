<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 欢迎页面
 * @author: lideqiang87@gmail.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */
class Welcome extends CI_Controller {

    function __construct(){
        parent::__construct();
    }

    /**
     * 首页
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
	public function index()
	{
        $id = $this->session->userdata('admin');
        if(empty($id)){
            $this->_error('请先登录', site_url('home/login'));
        }else{
            $data['user'] = $this->_getAdminInfo();
            $this->load->view('welcome', $data);
        }
	}
    
    /**
     * 获取管理员信息
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    private function _getAdminInfo(){

        $id = $this->session->userdata('admin');
        $info = check_admin($id);
        $admin_auth = check_admin_auth($info['user_group_id']);

        $userinfo['last_log_time'] = $_SERVER['REQUEST_TIME'];
        $userinfo['last_log_ip'] = $_SERVER['REMOTE_ADDR'];
        $userinfo['user_name'] = $this->session->userdata('adminname');
        $userinfo['groupname'] = $admin_auth['groupname'];

        return $userinfo;
    }

    /**
     * 登陆失败，跳转
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  string     $message    [description]
     * @param  string     $url        [description]
     * @param  integer    $waitSecond [description]
     * @return [type]                 [description]
     */
    private function _error($message = '失败', $url = '', $waitSecond = 3){
        $data = array(
            'jumpUrl' => $url,
            'message' => $message,
            'status' => 0,
            'waitSecond' => $waitSecond
        );
        $this->load->vars($data);
        $this->load->view('tip');
        $this->output->_display();
        die;
    }


}

/* End of file welcome.php */
/* Location: ./admin/controllers/welcome.php */
