<?php

/**
 * 网站设置
 * @author: lideqiang87@gmial.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */
class MWeb_global extends MY_Model{
    private $table = "web_global";
    public function __construct() {
        parent::__construct($this->table);
    }
}