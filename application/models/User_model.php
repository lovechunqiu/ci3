<?php
/**
 * Created by PhpStorm.
 * User: lovechunqiu
 * Date: 16/8/15
 * Time: 下午5:45
 */

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * insert data
     * @param array $data
     */
    public function insert_entry($data = array())
    {
        $data['created_time'] = time();
        $data['updated_time'] = time();
        return $this->db->insert('user', $data);
    }
}