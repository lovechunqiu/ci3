<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 重构redis
 * @author lideqiang87@gmail.com
 * @since 2016-09-21 19:48:12
 * @version 1.0.0
 */

class SktRedis {

    private $conn        = NULL;
    private $_host       = NULL;
    private $_port       = NULL;
    private $pool        = array();
    private $starup_size = 10;
    private $min_size    = 10;
    private $max_size    = 50;

    public function __construct($option = array()){
        $CI = &get_instance();
        $CI->config->load('redis', TRUE, TRUE);
        $conf        = $CI->config->config['redis'];
        $host        = ! empty($option['host']) ? $option['host'] : $conf['host'];
        $port        = ! empty($option['port']) ? $option['port'] : $conf['port'];
        $this->_host = $host;
        $this->_port = $port;
    }

    private function create_connection(){
        $conn = new Redis();
        $conn->connect($this->_host, $this->_port, 0) or die ("Could not connect to redis");

        return $conn;
    }

    private function close_connection($conn){
        if($conn){
            $conn->close();
        }
    }


    private function get_resource(){
        $conn = array_pop($this->pool);
        if(!$conn){
            $conn = $this->create_connection();
        }
        return $conn;
    }


    private function put_resource($conn){
        if($conn){
            if(count($this->pool) < $this->max_size){
                array_push($this->pool,$conn);
            }else{
                $this->close_connection($conn);
            }
        }
    }

    public function lrange($key, $start,$end,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->lrange($key, $start, $end);
        $this->put_resource($conn);
        return $res;
    }

    public function llen($key,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->llen($key);
        $this->put_resource($conn);
        return $res;
    }

    public function lpush($key, $val,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->lpush($key, $val);
        $this->put_resource($conn);
        return $res;
    }

    public function rpush($key, $val,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->rpush($key, $val);
        $this->put_resource($conn);
        return $res;
    }

    public function brpop($key, $timeout=30,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->brpop($key, $timeout);
        $this->put_resource($conn);
        return $res;
    }

    public function rpop($key,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->rpop($key);
        $this->put_resource($conn);
        return $res;
    }

    public function hincr($key, $field,$increment = 1, $db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->hincrby($key, $field, $increment);
        $this->put_resource($conn);
        return $res;
    }

    public function hreset($key, $field,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->hdel($key, $field);
        $this->put_resource($conn);
        return $res;
    }

    public function hset($key, $field, $value,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->hset($key, $field, $value);
        $this->put_resource($conn);
        return $res;
    }

    public function hkeys($key,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->hkeys($key);
        $this->put_resource($conn);
        return $res;
    }

    public function hget($key, $field,$db=0) {
        $conn = $this->get_resource();
        $conn->select($db);
        if(is_array($field)){
            $res = $conn->hmget($key, $field);
        }else{
            $res = $conn->hget($key, $field);
        }
        $this->put_resource($conn);
        return $res;
    }

    public function hgetall($key, $db = 0) {
        $conn = $this->get_resource();
        $conn->select($db);
        $res = $conn->hGetAll($key);
        $this->put_resource($conn);
        return $res;
    }

    public function sadd($key,$value,$db=0){
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->sadd($key, $value);
        $this->put_resource($conn);
        return $res;
    }


    public function set($key,$value,$db=0){
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->set($key, $value);
        $this->put_resource($conn);
        return $res;
    }

    public function get($key,$db = 0){
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->get($key);
        $this->put_resource($conn);
        return $res;
    }

    public function incr($key, $db = 0) {
        $conn = $this->get_resource();
        $conn->select($db);

        $res = $conn->incr($key);
        $this->put_resource($conn);
        return $res;
    }


    public function zrevrange($key,$start,$stop,$WITHSCORES=FALSE,$db = 0){
        $conn = $this->get_resource();
        $conn->select($db);

        if($WITHSCORES){
            $res = $conn->zrevrange($key,$start,$stop,'WITHSCORES');
        }else{
            $res = $conn->zrevrange($key,$start,$stop);
        }
        $this->put_resource($conn);
        return $res;
    }

    public function zrangebyscore($key,$min,$max,$WITHSCORES=FALSE,$limit=10,$offset=0,$db = 0){
        $conn = $this->get_resource();
        $conn->select($db);

        if($WITHSCORES){
            $res = $conn->zrangebyscore($key,$start,$stop,'WITHSCORES',$limit,$offset);
        }else{
            $res = $conn->zrangebyscore($key,$start,$stop);
        }
        $this->put_resource($conn);
        return $res;
    }

}
