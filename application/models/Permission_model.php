<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Permission_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = 'permission';
  }

  //try using container
  private function set_permission($code, $desc, $is_active)
}
