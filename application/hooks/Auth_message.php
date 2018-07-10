<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//https://www.codexworld.com/multi-language-implementation-in-codeigniter/

class Auth_Message
{
    function initialize()
    {
        $CI =& get_instance();
        $CI->load->helper('language');
        $CI->lang->load('auth_message','indonesia');
    }
}