<?php

/**
 * model
 * @author lideqiang
 * @since 2016-08-16
 * @version 1.0.0
 */

class MY_Model extends CI_Model{
    private $table = NULL;
    public function __construct($table = NULL)
    {
        $this->table = $table;
        parent::__construct();
    }

    /**
     * switch_db
     * @author lideqiang
     * @date   2016-08-16
     * @param  string     $db [description]
     * @return [type]         [description]
     */
    public function switch_db($db = 'default')
    {
        if ($db === 'default') {
            unset($this->db);
        } else {
            $this->db = $this->load->database($db, TRUE);
        }
    }

    /**
     * get
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function get($id)
    {
        return $this->get_by('id', $id);
    }

    /**
     * get_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $name  [description]
     * @param  [type]     $value [description]
     * @return [type]            [description]
     */
    public function get_by($name, $value)
    {
        if(!empty($value) && is_array($value)){
            $this->db->where_in($name, $value);
        }else{
            $this->db->where($name, $value);
        }
        $this->db->where('status', 1);
        return $this->db->get($this->table)->result_array();
    }

    /**
     * get
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function geto($id) {
        return $this->get_byo('id', $id);
    }

    /**
     * get_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $key   [description]
     * @param  [type]     $value [description]
     * @return [type]            [description]
     */
    public function get_byo($key, $value) {
        $this->db->where($key, $value);
        $this->db->where('status', 1);
        $res = $this->db->get($this->table, 1)->first_row();
        return $res ? json_decode(json_encode($res), TRUE) : array();
    }

    /**
     * 查询单条信息
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    function get_one($data){
        $this->db->where($data);
        $this->db->where('status', 1);
        $res = $this->db->get($this->table)->result_array();
        if (isset($res[0])) {
            return $res[0];
        }
        return false;
    }

    /**
     * 查询单条信息
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    function get_one_by($data){
        $this->db->where($data);
        $res = $this->db->get($this->table)->result_array();
        if (isset($res[0])) {
            return $res[0];
        }
        return false;
    }

    /**
     * query
     * @author lideqiang
     * @date   2016-08-16
     * @param  array      $condition [description]
     * @param  integer    $start     [description]
     * @param  integer    $size      [description]
     * @param  array      $order     [description]
     * @param  boolean    $join      [description]
     * @param  array      $like      [description]
     * @param  array      $group_by  [description]
     * @return [type]                [description]
     */
    public function query($condition = array(), $start = 0, $size = 0, $order = array(), $join = false, $like = array(), $group_by = array()) {
        if($condition){
            foreach($condition as $key => $value){
                if(is_array($value)){
                    $this->db->where_in($this->table.'.'.$key, $value);
                }else{
                    $this->db->where($this->table.'.'.$key, $value);
                }
            }
        }
        if($join){
            $on = $this->table.'.'.$join['on'][0].' = '.$join['table'].'.'.$join['on'][1];
            $this->db->join($join['table'], $on, 'left');
            if(! empty($join['condition'])){
                $keys = array_keys($join['condition']);
                $values = array_values($join['condition']);
                if(in_array('or', $keys) && $join['condition']['or']){
                    $where = '(';
                    foreach($keys as $ke => $va){
                        if($va == 'or') continue;
                        $where .= "{$join['table']}.{$va} = '{$values[$ke]}' OR ";
                    }
                    $where = trim($where, 'OR ').')';
                    $this->db->where($where);
                }else{
                    foreach($join['condition'] as $k => $v){
                        $this->db->where($join['table'].'.'.$k, $v);
                    }
                }
            }
            if( ! empty($join['fields'])){
                $this->db->select($join['fields']);
            }
        }

        if( ! empty($like)){
            if( ! empty($like['name'])){
                $position = ! empty($like['position']) ? $like['position'] : 'both';
                $this->db->like($like['name'], $like['value'], $position);
            }else{
                foreach ($like as $key => $value) {
                    $position = ! empty($value['position']) ? $value['position'] : 'both';
                    $this->db->like($value['name'], $value['value'], $position);
                }
            }
        }
        $size > 0 && $this->db->limit($size, $start);
        if( ! empty($group_by)){
            $this->db->group_by($group_by);
        }
        if( ! empty($order)){
            foreach($order as $key => $value){
                $this->db->order_by($key, $value);
            }
        }
        $res = $this->db->get($this->table)->result_array();
        // echo $this->db->last_query();die;
        return $res;
    }


    /**
     * gets_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $name_arr  [description]
     * @param  [type]     $value_arr [description]
     * @param  array      $order     [description]
     * @return [type]                [description]
     */
    public function gets_by($name_arr, $value_arr, $order = array())
    {
        foreach ($name_arr as $key => $name) {
            $this->db->where($name, $value_arr[$key]);
        }
        if($order) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        return $this->db->get($this->table)->result_array();
    }

    /**
     * count_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  array      $condition [description]
     * @return [type]                [description]
     */
    public function count_by($condition = array())
    {
        if($condition){
            foreach ($condition as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $count = $this->db->count_all_results($this->table);
        //echo $this->db->last_query();die;
        return $count;
    }

    /**
     * lists_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $name  [description]
     * @param  string     $order [description]
     * @param  integer    $limit [description]
     * @return [type]            [description]
     */
    public function lists_by($name, $order='DESC', $limit=10)
    {
        return $this->db->order_by($name, $order)->limit($limit)->get($this->table)->result_array();
    }

    /**
     * add
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $data [description]
     */
    public function add($data)
    {
        $data['created_time'] = $this->input->server("REQUEST_TIME");
        $data['updated_time'] = $this->input->server("REQUEST_TIME");
        $this->db->insert($this->table, $data);
        //echo $this->db->last_query();die;
        return $this->db->insert_id();
    }

    /**
     * update
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $id   [description]
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    public function update($id, $data)
    {
        $data['updated_time'] = $this->input->server("REQUEST_TIME");
        return call_user_func_array(array($this, 'update_by'), array('id', $id, $data));
    }

    /**
     * update_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $name  [description]
     * @param  [type]     $value [description]
     * @param  [type]     $data  [description]
     * @return [type]            [description]
     */
    public function update_by($name, $value, $data)
    {
        $this->db->update($this->table, $data, array($name => $value));
        return $this->db->affected_rows();
    }

    /**
     * update_to_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $condition [description]
     * @param  [type]     $data      [description]
     * @return [type]                [description]
     */
    public function update_to_by($condition, $data){
        $data['updated_time'] = $this->input->server("REQUEST_TIME");
        $this->db->where($condition);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();

    }

    /**
     * add_ignore
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $data [description]
     */
    public function add_ignore($data)
    {
        $insert_query = $this->db->insert_string($this->table, $data);
        $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
        return $this->db->query($insert_query);
    }

    /**
     * delete
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $id [description]
     * @return [type]         [description]
     */
    public function delete($id)
    {
        return call_user_func_array(array($this, 'delete_by'), array('id', $id));
    }

    /**
     * delete_by
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $name  [description]
     * @param  [type]     $value [description]
     * @return [type]            [description]
     */
    public function delete_by($name, $value)
    {
        return $this->db->delete($this->table, array($name => $value));
    }

    /**
     * define_query 自定义查询
     * @author lideqiang
     * @date   2016-08-16
     * @param  string     $where    [description]
     * @param  string     $fields   [description]
     * @param  array      $order    [description]
     * @param  array      $group_by [description]
     * @param  integer    $start    [description]
     * @param  integer    $size     [description]
     * @return [type]               [description]
     */
    public function define_query($where = '',  $fields = '*', $order = array(), $group_by = array(), $start = 0, $size = 0){
        if($where) {
            $this->db->where($where);
        }
        $this->db->select($fields);
        if($group_by){
            $this->db->group_by($group_by);
        }
        if($order) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        $size > 0 && $this->db->limit($size, $start);

        $result = $this->db->get($this->table)->result_array();
        //echo $this->db->last_query();die;
        return $result;
    }

    /**
     * 插入多条记录
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $data [description]
     * @return [type]           [description]
     */
    public function insert_array($data){
        if( ! empty($data)){
            foreach ($data as $key => $value) {
                $data[$key]['created_time'] = $this->input->server("REQUEST_TIME");
                $data[$key]['updated_time'] = $this->input->server("REQUEST_TIME");
            }
        }
        $reuslt = $this->db->insert_batch($this->table, $data);
        return $reuslt;
    }

    /**
     * update_to_in  批量更新
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $name  [description]
     * @param  [type]     $value [description]
     * @param  [type]     $data  [description]
     * @return [type]            [description]
     */
    public function update_to_in($name, $value, $data){
        $data['updated_time'] = $this->input->server("REQUEST_TIME");
        $this->db->where_in($name, $value);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    /**
     * 累加
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $where  [description]
     * @param  [type]     $field  [description]
     * @param  string     $values [description]
     * @return [type]             [description]
     */
    public function update_sum_params($where, $field, $values = ''){
        $sql = "update " . $this->table . " set " . $field . " = " . $field . " + 1 " . ($values ? " , " . $values : "") . " where " . $where;
        $this->db->query($sql);
        $result = $this->db->affected_rows();
        //echo $this->db->last_query();die;
        return $result;
    }

    /**
     * 对于某个字段求和
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $fields    [description]
     * @param  array      $condition [description]
     * @return [type]                [description]
     */
    public function select_num($fields, $condition = array()){
        if($condition){
            $this->db->where($condition);
        }
        $this->db->select_sum($fields);
        $res = $this->db->get($this->table, 1)->first_row();
        // echo $this->db->last_query();die;
        return $res ? json_decode(json_encode($res), TRUE) : array();
    }

    /**
     * query查询方式
     * @author lideqiang
     * @date   2016-08-16
     * @param  [type]     $query [description]
     * @return [type]            [description]
     */
    public function my_query($query){
        $result = $this->db->query($query)->result_array();
        return $result;
    }


}
