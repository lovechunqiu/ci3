<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台权限管理
 * @author: lideqiang@cxshiguang.com
 * @version: 1.0.0
 * @since: 2015-10-24
 */
class Auth extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model(array('madmin_auth', 'madmin'));
    }

    /**
     * 列表页面
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-24
     * @return [type]     [description]
     */
	public function index(){

        $condition = array('status' => 1);
        
        $count = $this->madmin_auth->count_by($condition);
        
        //分页
        $show = $this->show_page($count);

		$order = array('id' => 'asc');
		$list = $this->madmin_auth->query($condition, $show['start'], $show['page_size'], $order);

        $data['auth_list'] = $list;
        $data['position']  = '用户组权限';
        $data['pagebar']  = $show['show'];

        $this->_return('auth/index', $data);
	}

	/**
	 * 添加页面
	 * @author lideqiang@cxshiguang.com
	 * @date   2015-10-24
	 */
	public function add()
    {
		require "./auth.inc.php";
		$data['auth_list'] = $auth_inc;
		$this->_return('auth/add', $data);
    }

    /**
     * 提交保存
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-24
     * @return [type]     [description]
     */
    public function doAdd()
    {
    	$this->load->driver('cache', array('adapter' => 'file'));
    	$post = $this->data;

		$data['controller'] = serialize($post['model']);
		$data['groupname']  = $post['groupname'];

		$newid = $this->madmin_auth->add($data);
		if(empty($newid)){
			$this->error('权限管理添加失败', site_url('auth/index'));
		}
		$this->cache->save('AUTH_all', NULL);
		$this->success('用户组权限添加成功', site_url('auth/index'));
    }
    
    /**
     * 编辑
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-24
     * @return [type]     [description]
     */
    public function edit(){
		require "./auth.inc.php";
		$id = $this->input->get('id', TRUE);
		if($id==0){
			$this->error('参数错误', site_url('auth/index'), 2);
		}

		$info = check_admin_auth($id);
		$info['controller'] = unserialize($info['controller']);

		$data['id'] = $id;
		$data['authdata'] = $info;
		$data['auth_list'] = $auth_inc;

		$this->_return('auth/edit', $data);
    }

    /**
     * 编辑保存
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-24
     * @return [type]     [description]
     */
    public function doEdit(){

    	$this->load->driver('cache', array('adapter' => 'file'));
    	$post = $this->data;

		$id = $post['id'];
		if($id==0){
			$this->error('参数错误', site_url('auth/index'), 2);
		}

		$data['controller'] = serialize($post['model']);
		$data['groupname']  = $post['groupname'];

		$result = $this->madmin_auth->update($id, $data);

		if($result){
			$this->cache->save('AUTH_' . $id, NULL);
			$this->cache->save('AUTH_all', NULL);
			$this->success('修改成功', site_url('auth/index'));
		}else{
			$this->error('修改失败或者数据未做修改', site_url('auth/index'));
		}
    }

    /**
     * 删除
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-24
     * @return [type]     [description]
     */
    public function doDelete(){

    	$post = $this->data;
    	$id_arr = explode(',', $post['idarr']);
    	$have_user = $this->madmin->get_by('user_group_id', $id_arr);
		if(is_array($have_user) && count($have_user) > 0){
			$this->callback_json(0, '该用户组权限下有会员，不能删除');
		}
		$delnum = $this->madmin_auth->update_admin_auth($id_arr, array('status' => 0, 'updated_time' => time()));
		if($delnum){
			$this->callback_json(1, '用户组权限删除成功');
		}else{
			$this->callback_json(1, '用户组权限删除失败');
		}
    }

}

/* End of file auth.php */
/* Location: ./admin/controllers/auth.php */
