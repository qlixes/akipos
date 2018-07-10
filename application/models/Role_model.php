<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Role_model extends MY_Model implements IModel
{
  protected $table = 'role';

  public function __construct()
  {
    parent::__construct();
    $this->filter['role'] = array('name');
  }

  public function registration()
  {
    $this->filter('role')->add();
  }

  public function findAndRemove($key = array())
  {
    $this->show_full($key)->erase();
  }

  public function findAndUpdate($key = array())
  {
    $this->filter('role')->show_full($key)->edit();
  }

  public function findAll()
  {
    return $this->show()->result('array');
  }

  public function findBy($key = array())
  {
    return $this->show_full($key)->row_array();
  }
}
