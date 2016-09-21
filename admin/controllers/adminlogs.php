<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 操作日志
 * @author lideqiang87@gmail.com
 * @date   2016-09-21 14:03:12
 * @return [type]     [description]
 */

class Adminlogs extends MY_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model(array(
            'madmin_logs'
        ));
        $this->jumpUrl = site_url('adminlogs/index');
        $this->timeOut = 2;
    }

    /**
     * 列表页面
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
	public function index(){
        //查询条件
        $sea_con = $this->_search_condition();
        $where   = $sea_con['where'];
        $search  = $sea_con['search'];
        $cList   = $this->madmin_logs->my_query($where);
        //总数
        $count   = count($cList);
        $show    = $this->show_page($count);
        if ($show['page_size'] > 0) {
            $str = '';
            if ($show['start'] > 0) {
                $str = ' OFFSET ' . $show['start'];
            }
            $where = $where . ' LIMIT ' . $show['page_size'] . $str;
        }
        //重新计算课程表
        $list = $this->madmin_logs->my_query($where);
        $data['search_name'] = '搜索/筛选';
        $data['position']    = '操作日志';
        $data['list']        = $list;
        $data['pagebar']     = $show['show'];
        $data['search']      = $search;
        $data['query']       = http_build_query($search);
        $this->_return('adminlogs/index', $data);
	}     

    /**
     * 查询条件
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    private function _search_condition(){
        $get    = $this->input->get(NULL, TRUE);
        $search = array();
        $where  = 'SELECT id, name, mobile, created_time, `desc` FROM (`admin_logs`) where status = 1';
        //关键词搜索
        if ( ! empty($get['keywords'])) {
            $key    = trim($get['keywords']);
            $where .= ' and (`desc` like "%' . $key . '%" OR `name` like "%' . $key . '%"
                        OR `mobile` like "%' . $key . '%")';
            $search['keywords'] = $get['keywords'];
        }
        if( ! empty($get['created_start'])){
            $where .= ' and created_time >= ' . strtotime($get['created_start']);
            $search['created_start']  = $get['created_start'];
        }
        if( ! empty($get['created_end'])){
            $where .= ' and created_time <= ' . strtotime($get['created_end'] . '23:59:59');
            $search['created_end']    = $get['created_end'];
        }
        $where .= ' order by id desc ';
        return array('where' => $where, 'search' => $search);
    }


}



/* End of file Adminlogs.php */
/* Location: ./admin/controllers/Adminlogs.php */



