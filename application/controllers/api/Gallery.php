<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends API_Controller
{
  public function index()
  {
    return json_encode($this->input->request_headers());
  }
}
