<?php

class MUser extends MY_Model {
    private $table = 'user';
    public function __construct(){
        parent::__construct($this->table);
    }
}
