<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminuser extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model(array('madmin'));
    }

	public function index(){
        $group_id  = $this->session->userdata('user_group_id');
        $condition = array('status' => 1);
        $data['position'] = '管理员';
        if( ! empty($group_id) && $group_id == 5){
            $condition['pid'] = $this->session->userdata('admin');
            $data['is_show']  = 1;
            $data['position'] = '商家';
        }
        $count = $this->madmin->count_by($condition);
        //分页
        $show  = $this->show_page($count);
        $AdminUserList = $this->madmin->query($condition, $show['start'], $show['page_size']);
        $GroupArr      = get_group_data();
        foreach($AdminUserList as $key => $v){
            $AdminUserList[$key]['groupname'] = $GroupArr[$v['user_group_id']]['groupname'];
        }
        $data['group_id']   = $group_id;
        $data['pagebar']    = $show['show'];
        $data['admin_list'] = $AdminUserList;
        $data['group_list'] = $GroupArr;
        $this->_return('adminuser/index', $data);
	}
        
    /**
     * 添加管理员
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-07
     */
    public function addAdmin(){
        $post = $this->input->post(NULL, TRUE);
        $url  = site_url('adminuser/index');
        $post['univalent'] = ! empty($post['univalent']) ? $post['univalent'] * 100 : 100;

        //判断管理员用户名是否存在
        $this->_admin_user_check($post);

        //编辑
        if( ! empty($post['uid'])){
            $aid = $post['uid'];
            $admin_info = $this->madmin->geto($aid);
            if($admin_info['user_group_id'] != 5 && $post['user_group_id'] == 1){
                $this->error('已经有超级管理员了！超级管理员只能有一位！', $url);
            }
            if( ! empty($post['user_pass'])){
                $post['user_pass'] = md5($post['user_pass']);
            }
            unset($post['uid']);
            $result = $this->madmin->update($aid, array_filter($post));
            if($result){
                $this->success('修改成功', $url);
            }else{
                $this->error('修改失败', $url);
            }
        }else{
            $aid  = $this->session->userdata('admin');
            $post['pid'] = ! empty($aid) ? $aid : '';
            //检测是否已经有了超级管理员
            $super_man = $this->madmin->get_one(array('status' => 1, 'user_group_id' => 1));
            if(isset($super_man) && $super_man['user_group_id'] == $post['user_group_id']){
                $this->error('已经有超级管理员了！超级管理员只能有一位！', $url);
            }
            $post['user_pass'] = md5($post['user_pass']);
            $result = $this->madmin->add($post);
            if($result){
                $this->success('添加成功', $url);
            }else{
                $this->error('添加失败', $url);
            }
        }
    }

    /**
     * 删除
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-07
     * @return [type]     [description]
     */
    public function doDelete(){
        $this->doDel('madmin');
    }

    /**
     * 检测管理员用户名是否存在
     * @author lideqiang@cxshiguang.com
     * @date   2016-02-22
     * @param  [type]     $post [description]
     * @return [type]           [description]
     */
    private function _admin_user_check($post){
        if( ! empty($post['uid'])){
            $info = $this->madmin->geto($post['uid']);
            if( ! empty($info) && ($info['user_name'] != $post['user_name'])){
                $this->_get_info_by_name($post['user_name']);
            }
        }else{
            $this->_get_info_by_name($post['user_name']);
        }
    }

    /**
     * 通过用户名获取信息
     * @author lideqiang@cxshiguang.com
     * @date   2016-02-22
     * @param  [type]     $user_name [description]
     * @return [type]                [description]
     */
    private function _get_info_by_name($user_name){
        $info = $this->madmin->get_one(array('user_name' => $user_name));
        if($info){
            $this->error(return_str('admin_user_exists'), site_url('adminuser/index'));
        }
    }
   
}

/* End of file adminuser.php */
/* Location: ./admin/controllers/adminuser.php */
