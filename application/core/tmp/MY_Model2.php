<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
  private $data = array();
  private $tmp = array();

  protected $table;

  protected $status = false;

  private $num_rows;

  protected function set_data($data = array(), $reset = FALSE)
  {
    if ($reset) {
      $this->data = null;
    };
    $this->data = array_merge($data, $this->data);
  }

  private function get_data()
  {
    return $this->data;
  }

  public function add()
  {
    return $this->db->insert($this->table, $this->get_data());
  }

  public function edit()
  {
    return $this->db->replace($this->table, $this->get_data());
  }

  public function erase()
  {
    return $this->db->delete($this->table, $this->get_data());
  }

  public function show($field = null, $limit = 20)
  {
    if ($field)
    {
      $this->db->select($field);
    };
    return $this-db->get($this->table, $limit);
  }

  //filter for $this->data
  public function filter($field = array(),$show = false)
  {
    //reset
    $this->tmp = null;
    //for recovery first value
    $this->tmp['old'] = $this->get_data();
    foreach($field as $key){
      $arr[$key] = $this->tmp['old'][$key]
    };
    $this->set_data($arr, true);
    if ($show) {
      $this->showFull();
      $this->num_rows = $this->show()->num_rows();
    };
  }

  public function reset_data($use = false)
  {
    if ($use) {
      $this->tmp['saved'] = $
    }
    $this->set_data($this->tmp['old'], true);
  }

  // depends on filter && must have 1 result
  public function is_exists()
  {
    $this->showFull();
    return ($this->show()->num_rows() == 1)
  }

  public function get_id()
  {
    return $this->num_rows->id;
  }

  //like
  public function showPartial()
  {
    $this->db->like($this->get_data());
  }

  //where
  public function showFull()
  {
    $this->db->where($this->get_data());
  }

  protected function custom_qry($sql, $bind = array())
  {
    $this->db->query($sql, $bind);
  }

  public function set_active($yes = true)
  {
    $this->set_data(array(
      'is_active' => ($yes) ? 1 : 0,
    ));
    $this->edit();
  }

  public function search_list($fields = null)
  {
      $this->showPartial();
      return $this->show($fields);
  }

  public function search_row($fields = null)
  {
      $this->showFull();
      return $this->show($fields);
  }

  // @data array list of field needed
  protected function hasOne($table, $data = array())
  {
    $this->table = $table;
    // check on parent's filter()
    if ($this->exists()) {
      $this->filter($data, true);
    }
  }
}
