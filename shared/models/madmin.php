<?php

/**
 * 管理员model
 * @author: lideqiang87@gmial.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */

class MAdmin extends MY_Model{
    private $table = "admin";
    public function __construct() {
        parent::__construct($this->table);
    }
}