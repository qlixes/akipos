<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Config_model extends MY_Model implements IModel
{
  protected $table = 'configs';

  public function registration()
  {
    $this->set_data(array(
      'cfg_code'  =>  $this->input['cfg_code'],
      'cfg_value' =>  $this->input['cfg_value'],
      'is_enable'  =>  $this->input['is_enable']
    ))->add();
  }

  public function findAndRemove($key = array())
  {
    $this->show_full($key)->erase();
  }

  public function findAndUpdate($key = array())
  {
    $this->set_data(array(
      'cfg_code'  =>  $this->input['cfg_code'],
      'cfg_value' =>  $this->input['cfg_value'],
      'is_enable'  =>  $this->input['is_enable']
    ))->show_full($key)->edit();
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
