<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    protected $meta_keywords = array('ci3框架搭建');
    protected $meta_desc = '';

    protected $meta_mobile_agent = '';
    protected $meta_robots = '';
    protected $title = array('框架');

    function __construct() {
        parent::__construct();
    }

    /**
     * view
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $page     [description]
     * @param  array      $data     [description]
     * @param  string     $template [description]
     * @return [type]               [description]
     */
    public function _return($page, $data = array(), $template = 'page') {
        $this->load->vars($data);
        $this->load->vars(array(
            'page'              => $page,
            'title'             => $this->title,
            'meta_keywords'     => $this->meta_keywords,
            'meta_mobile_agent' => $this->meta_mobile_agent,
            'meta_desc'         => $this->meta_desc,
            'meta_robots'       => $this->meta_robots,
        ));
        $this->load->view('common/' . $template);
    }

}

