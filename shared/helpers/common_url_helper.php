<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('static_url')) {
    function static_url($uri = '', $timestamp = '') {
        static $s_base_url;
        if( ! $s_base_url) {
            $ci =& get_instance();
            $ci->load->config('common_url');
            $static_arr = $ci->config->item('static_url');
            $s_base_url = '';
            $static_sum = array_sum($static_arr);
            foreach ($static_arr as $url => $static_num) {
                $rand_num = mt_rand(1, $static_sum);
                if ($rand_num <= $static_num) {
                    $s_base_url = rtrim($url, '/') . '/';
                    break;
                } else {
                    $static_sum -= $static_num;
                }
            }
        }
        return $s_base_url . $uri . ( ! empty($timestamp) ? "?$timestamp" : '');
    }
}

if ( ! function_exists('wap_url')) {
    function wap_url($uri='', $timestamp = '') {
        static $s_base_url;
        if( ! $s_base_url) {
            $ci =& get_instance();
            $ci->load->config('common_url');
            $s_base_url = $ci->config->slash_item('wap_url');
        }
        return $s_base_url . $uri . ( ! empty($timestamp) ? "?$timestamp" : '');
    }
}
