<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    protected $meta_keywords = array('精神','专心','永恒','坚持');
    protected $meta_mobile_agent = '';
    protected $meta_desc   = '后台管理';
    protected $meta_robots = '';
    protected $title       = array('后台管理中心');
    protected $start       = 0;
    protected $pagesize    = 10;
    protected $data        = NULL;
    protected $moduel_name = '';
    protected $action_name = '';
    protected $admin_id    = 0;
    protected $justlogin   = FALSE;

    function __construct() {
        parent::__construct();
        
        //控制器
        $controller = $this->router->fetch_class();
        //方法
        $function   = $this->router->fetch_method();

        define('MODULE_NAME', $controller);
        define('ACTION_NAME', $function);

        $this->load->helper('admin');
        $this->data = $this->input->post(NULL, TRUE);

        //有些方法是不需要进行校验的
        if( ! (MODULE_NAME == 'appversion' && ACTION_NAME == 'callbackapk')){
            $this->_check_auth();
        }
    }

    /**
     * view 输出
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
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
            'css'               => array(
                'static/admin/css/style.css',
                'static/admin/css/main.css',
            ),
            'script'            => array(
                'static/admin/js/plugins/ui/jquery-1.7.1.min.js',
                'static/admin/js/common.js',
                'static/admin/js/plugins/ui/admincommon.js',
            ),
        ));
        $this->load->view('common/' . $template);
    }
    
    /**
     * 登陆成功，跳转
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  string     $message    [description]
     * @param  string     $url        [description]
     * @param  integer    $waitSecond [description]
     * @return [type]                 [description]
     */
    public function success($message = '成功', $url = '', $waitSecond = 3){
        
        $data = array(
            'jumpUrl' => $url,
            'message' =>$message,
            'status' => 1,
            'waitSecond' => $waitSecond
        );
        $this->load->vars($data);
        $this->load->view('tip');
        $this->output->_display();
        die;
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
    public function error($message = '失败', $url = '', $waitSecond = 3){
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

    /**
     * json返回值
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-07
     * @param  integer    $status [description]
     * @param  string     $info   [description]
     * @param  array      $data   [description]
     * @return [type]             [description]
     */
    public function callback_json($status = 1, $info = '成功', $data = array()){
        echo json_encode(array('status' => $status, 'info' => $info, 'data' => $data));die;
    }

    /**
     * 分页显示
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  [type]     $total     [description]
     * @param  string     $parameter [description]
     * @param  string     $p         [description]
     * @return [type]                [description]
     */
    public function show_page($total, $parameter = '', $p = 'p'){
        if( ! empty($_GET[$p])){
            $this->start = ($_GET[$p] -1) * $this->pagesize;
        }
        //起始页
        $start     = $this->start;
        //每页显示数
        $page_size = $this->pagesize;

        $options = array(
            'totalRows' => $total,
            'listRows'  => $page_size,
            'p'         => $p,
        );
        if( ! empty($parameter)){
            $options['parameter'] = $parameter;
        }
        $this->load->library('page', $options);
        // 分页显示输出
        $show = $this->page->show();
        return array('show' => $show, 'start' => $start, 'page_size' => $page_size);
    }

    /**
     * 删除
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  [type]     $model    [description]
     * @param  string     $recovery [description]
     * @return [type]               [description]
     */
    public function doDel($model, $recovery = ''){
        $post = $this->data;
        $ids = $post['idarr'];
        $idarr = explode(',', $ids);
        if($recovery){
            $name = '恢复';
            $data = array('status' => 1);
        }else{
            $name = '删除';
            $data = array('status' => 0);
        }
        if(empty($idarr)){
            $this->callback_json(0, $name . '对象不能为空');
        }
        foreach ($idarr as $key => $value) {
            $this->$model->update($value, $data);
        }
        $this->callback_json(1, $name . '成功');
    }

    /**
     * 权限校验
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    private function _check_auth(){

        !isset($this->justlogin)?$this->justlogin=false:$this->justlogin=$this->justlogin;

        $this->admin_id = $this->session->userdata('admin');

        $query_string = explode("/", $_SERVER['REQUEST_URI']);

        if( ! empty($this->admin_id)){
            $this->load->vars(array('adminname' => $this->session->userdata('adminname')));
        }elseif(strtolower(ACTION_NAME) != 'verify' && strtolower(ACTION_NAME) != 'login' && strtolower(ACTION_NAME)!='logincheck'){
            redirect("home/logincheck?code=" . $query_string[1]);
            exit;
        }
        if( ! get_user_auth($this->admin_id) && ! $this->justlogin){
            if(empty($this->admin_id)){
                $site_url = site_url('home/login');
            }else{
                $site_url = site_url('welcome/index');
            }
            $this->error('权限不足', $site_url);
        }
    }

    /**
     * 上传图片
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  [type]     $name [description]
     * @param  string     $path [description]
     * @return [type]           [description]
     */
    public function upload_img($name, $path = ''){

        $config['upload_path']          = ! empty($path) ? $path : C('skt_config.img_path');
        $config['allowed_types']        = '*';
//        $config['max_size']             = 100;
//        $config['max_width']            = 1024;
//        $config['max_height']           = 768;
        $config['encrypt_name']         = TRUE;
        $config['file_ext_tolower']     = TRUE;
        
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload($name))
        {
            $error = array('error' => $this->upload->display_errors());
            $result = array(
                'status'  => FALSE,
                'error'   => $error['error'],
                'message' => array(),
            );
            return $result;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $result = array(
                'status'  => TRUE,
                'error'   => '',
                'message' => array('file_name' => $data['upload_data']['file_name'])
            );
            return $result;
        }
    }


}
