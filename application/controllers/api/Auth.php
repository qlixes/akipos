<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *   var_dump($this->input->post('fuckup')); //using with form post
 *   var_dump($this->input->request_headers()); //set data with set_header
 *   var_dump($this->input->raw_input_stream); //get data with any method form/json
 */
class Auth extends API_Controller
{
  public function index()
  {
    var_dump($this->request->getServerParams());
  }
}
