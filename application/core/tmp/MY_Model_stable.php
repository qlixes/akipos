<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('PAGE_PER_PAGE', 44);

class MY_Model extends CI_Model
{
  private $data = array();
  private $tmp = array();

  protected $table;

  protected $status = false;

  protected $num_rows;

  public function __construct()
  {
    parent::__construct();
  }

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

  public function show($field = null)
  {
    if ($field)
    {
      $this->db->select($field);
    };
    return $this->db->get($this->table, $this->config->default_cfg(PAGE_PER_PAGE, 20));
  }

  //filter for $this->data
  public function filter($field = array(),$show = false)
  {
    //reset
    try {
      if (!empty($this->get_data())) {
        $this->tmp = null;
        $this->tmp['src'] = $this->get_data();
        foreach($field as $key){
          $arr[$key] = $this->tmp['src'][$key];
        };
        $this->set_data($arr, true);
      };
      if ($show) {
        $this->showFull();
        // $this->num_rows = $this->show()->num_rows();
        $this->num_rows = $this->search_row();
      };
      //back as input array
      $this->reset_data();
    } catch (Exception $e) {
      return $e->getMessage();
    }

  }
  // back to original
  public function reset_data()
  {
    if (!empty($this->tmp['src'])) {
      $this->set_data($this->tmp['src'], true);
    };
  }

  public function get_rows()
  {
    return $this->num_rows;
  }

  // depends on filter && must have 1 result
  public function is_exists()
  {
    $this->showFull();
    return ($this->show()->num_rows() == 1);
  }

  // @data array list of field needed
  // TODO : separator for multiple as filter does
  protected function hasOne($table, $data = array())
  {
    // check on parent's filter()
    if ($this->exists()) {
      $this->table = $table;
      // adding parent_id
      $this->set_data(array(
        'id'  =>  $this->get_id()
      ));
      if (!is_null($data)) {
        $this->filter($data);
      };
      return $this;
    } else throw new Exception('Does not has parent');
  }

  public function get_id()
  {
    return $this->num_rows->id;
  }

  //like
  private function showPartial()
  {
    $this->db->like($this->get_data());
  }

  //where
  private function showFull()
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
      //return object
      return $this->show($fields)->row();
  }
}
