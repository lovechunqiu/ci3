<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->vars(array(
            'css'    => array(
                'static/css/main.css',
            ),
            'script' => array(
                'static/js/jquery.js',
            ),
        ));
		$this->load->model('muser');
	}
	/**
	 * 初始化参数
	 */
	public function index()
	{
		$this->_return('welcome_message');
	}

	/**
	 * 添加
	 */
	public function we_add(){
		$post = $this->input->post();
		$data['username'] = $post['username'];
		$data['password'] = $post['password'];
		$this->session->set_userdata($data);
		$result = $this->muser->add($data);
		if($result){
			dump('注册成功');
		}else{
			dump('注册失败');
		}
	}

}
