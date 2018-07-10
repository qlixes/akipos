<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor
{
    private $CI;
    private $_agent;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('user_agent');
    }

    private function show_platform()
    {
        if(!$this->CI->agent->is_robot()) {
            $data = ($this->CI->agent->is_mobile()) ? $this->CI->agent->mobile() : $this->CI->agent->browser();
        } else {
            $data = $this->CI->agent->robot();
        }
        return $data;
    }

    public function show_info()
    {
        return array(
            'origin_ip'  => $this->CI->input->ip_address(),
            'origin_platform'   => $this->show_platform()
        );
    }
}
