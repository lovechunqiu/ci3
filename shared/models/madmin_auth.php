<?php

/**
 * 管理角色model
 * @author: lideqiang87@gmial.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */
class MAdmin_auth extends MY_Model{
    private $table = "admin_auth";
    public function __construct() {
        parent::__construct($this->table);
    }

    /**
     * 批量更新
     * @author lideqiang87@gmial.com
     * @date   2016-09-21
     * @param  [type]     $idarr [description]
     * @param  [type]     $data  [description]
     * @return [type]            [description]
     */
    public function update_admin_auth($idarr, $data){

    	$this->db->where_in('id', $idarr);
    	$this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
}