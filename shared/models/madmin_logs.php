<?php

/**
 * 后台操作日志model
 * @author: lideqiang87@gmial.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */

class MAdmin_logs extends MY_Model{
    private $table = "admin_logs";
    public function __construct() {
        parent::__construct($this->table);
    }
}
