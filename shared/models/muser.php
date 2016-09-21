<?php

/**
 * 用户model
 * @author: lideqiang87@gmial.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */

class MUser extends MY_Model {
    private $table = 'user';
    public function __construct(){
        parent::__construct($this->table);
    }
}
