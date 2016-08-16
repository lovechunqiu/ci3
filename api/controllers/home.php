<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('muser');
	}
	/**
	 * 初始化参数
	 */
	public function index(){
        exit('api接口开发');
	}

}
