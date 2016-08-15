<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
	/**
	 * 初始化参数
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	/**
	 * 添加
	 */
	public function we_add(){
		$post = $this->input->post();
		$data['username'] = $post['username'];
		$data['password'] = $post['password'];
		$this->session->set_userdata($data);
		$result = $this->user_model->insert_entry($data);
		if($result){
			print('注册成功');
		}else{
			print('注册失败');
		}
	}

}
