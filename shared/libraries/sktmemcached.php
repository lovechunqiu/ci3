<?php
/**
 * Created by PhpStorm.
 * User: lideqiang
 * Date: 15/7/28
 * Time: 08:00
 */
class SktMemcached {
    private $_memcached = NULL;
    private $_host = NULL;
    private $_port = NULL;

    private function _check_connect() {
        if (! $this->_memcached) {
            $CI =& get_instance();
            $CI->config->load('memcached', TRUE, TRUE);
            $conf = $CI->config->config['memcached'];
            $this->_host = $conf['host'];
            $this->_port = $conf['port'];
            $this->_memcached = new Memcache();
            $this->_memcached->pconnect($conf['host'], $conf['port']) or die ("Could not connect to mc");
        }
        return TRUE;
    }

    public function add($key, $val, $expire=7200) {
        if ($this->_check_connect()) {
            return $this->_memcached->set($key, $val, 0, $expire);
        }
        return FALSE;
    }

    public function set($key, $val, $expire=3600) {
        if ($this->_check_connect()) {
            return $this->_memcached->set($key, $val, 0, $expire);
        }
        return FALSE;
    }

    public function get($key) {
        if ($this->_check_connect()) {
            return $this->_memcached->get($key);
        }
        return FALSE;
    }

    public function del($key) {
        if ($this->_check_connect()) {
            return $this->_memcached->delete($key, 0);
        }
        return FALSE;
    }

    public function flush() {
        if ($this->_check_connect()) {
            return $this->_memcached->flush();
        }
        return FALSE;
    }

    public function getExtendedStats() {
        if ($this->_check_connect()) {
            return $this->_memcached->getExtendedStats();
        }
        return FALSE;
    }

    public function get_link() {
        return $this->_host . ':' . $this->_port;
    }
}
