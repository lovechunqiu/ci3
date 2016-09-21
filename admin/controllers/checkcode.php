<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 验证码
 * @author: lideqiang87@gmail.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */
class Checkcode extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('captcha', 'SktMemcached'));
    }

    public function index() {
        //4 生成4个字符
        $code = $this->captcha->create(4, '0123456789');
        $session_id = $this->session->userdata('session_id');
        //$this->sktmemcached->set('captcha' . $session_id, $code, 1200);
        $this->session->set_userdata(array('captcha' . $session_id => $code));
    }

    /**
     * status返回值说明
     * 1  验证码正确
     * 0  验证码错误
     * -1 验证码尝试1次，刷新验证码
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    public function check() {
        $post = $this->input->post(NULL, TRUE);
        $res['status'] = C('status.json.error');
        if ($post && isset($post['code'])) {
            $code = $post['code'];
            $session_id = $this->session->userdata('session_id');
            $captcha = $this->sktmemcached->get('captcha' . $session_id);
            $suffix_key = strtolower($this->input->cookie('__permanent_id'));
            $mem_key = 'five_times_captcha_check_' . $suffix_key;
            if ((strtolower($code) == $captcha) && ($captcha != '')) {
                $res['status'] = C('status.json.success');
            } else {
                $this->session->unset_userdata('captcha');
                $res['status'] = C('status.json.error');
            }
            $this->sktmemcached->del($mem_key);
        }
        echo json_encode($res);
    }
}

/* End of file captcha.php */
/* Location: ./application/controllers/captcha.php */
