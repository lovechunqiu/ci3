<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 全局设置
 * @author: lideqiang@cxshiguang.com
 * @version: 1.0.0
 * @since: 2015-10-26
 */

class Setting extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model(array('mweb_global'));
    }

	/**
     * 网站设置
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-05
     * @return [type]     [description]
     */
    public function websetting(){
        $condition = array(
            'status'  => 1,
        );
        $order = array('order_sn' => 'desc');
        $list = $this->mweb_global->query($condition, '', '', $order);
        
        $data['position'] = '网站设置';
        $data['list']     = $list;
        
        $this->_return('setting/websetting', $data);
    }

    /**
     * 添加参数
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function doAdd(){
        $post = $this->data;

        $result = $this->mweb_global->add($post);
        if($result){
            $this->callback_json(1, '添加成功');            
        }else{
            $this->callback_json(0, '添加失败');
        }
    }

    /**
     * 提交
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function doEdit(){

        $data = $this->data;
        foreach($data as $key => $v){
            if(is_numeric($key)){
                $this->mweb_global->update($key, array('text' => $v));
            }
        }
        $this->success('更新成功', site_url('setting/websetting'), 1);
    }

    /**
     * 删除
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function doDelweb(){

        $data = $this->data;
        $info = $this->mweb_global->geto($data['id']);

        if($info['is_sys'] == 1){
            $a_data['status'] = 0;
            $a_data['message'] = "系统参数，禁止删除";
            exit(json_encode($a_data));
        }

        $delnum = $this->mweb_global->update($data['id'], array('status' => 0)); 
        
        if($delnum){            
            $a_data['status'] = 1;
            $a_data['id'] = $data['id'];
            $a_data['message'] = '删除成功';
        }else{
            $a_data['status'] = 0;
            $a_data['message'] = "删除失败";
        }
        
        exit(json_encode($a_data));
    }

    /**
     * 清除缓存
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-04
     * @return [type]     [description]
     */
    public function cleanall(){

        $cache_data_path = RUNTIME_PATH . 'Data/';
        $dirs   =   array($cache_data_path);
        foreach($dirs as $value){
            rmdirr($value);
            @mkdir($value,0777,true);
        }
        $this->success('缓存清除成功',site_url('welcome/index'));
    }
 
}

/* End of file setting.php */
/* Location: ./admin/controllers/setting.php */
