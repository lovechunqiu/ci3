<?php

/**
 * 网站设置
 * @author: lideqiang@cxshiguang.com
 * @version: 1.0.0
 * @since: 2015-10-26
 */
class MWeb_global extends MY_Model{
    private $table = "web_global";
    public function __construct() {
        parent::__construct($this->table);
    }
}