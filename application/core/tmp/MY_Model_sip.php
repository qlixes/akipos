<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('PAGE_PER_PAGE', 44);

class MY_Model extends CI_Model
{
  private $data = array();
  private $tmp = array();

  public $input = array();

  protected $table;
  protected $limit;

  protected $parent;
  protected $child;

  public function __construct()
  {
    parent::__construct();
    $this->limit = $this->config->default_cfg(PAGE_PER_PAGE, 20);
  }

  //merge array into old array
  public function set_data($data = array(), $reset = true)
  {
    //if old data is empty
    if ($reset) {
      $this->data = array();
    };
    $this->data = array_merge($data, $this->data);
    return $this;
  }

  public function get_data()
  {
    return $this->data;
  }

  public function add()
  {
    if ($this->db->insert($this->table, $this->get_data())) {
      return $this;
    } else throw new Exception('failed add');
  }

  public function edit()
  {
    if($this->db->update($this->table, $this->get_data())) {
    return $this;
  } else throw new Exception('failed edit');
  }

  public function erase()
  {
    if($this->db->delete($this->table, $this->get_data())) {
      return $this;
    } else throw new Exception('failed erase');
  }

  public function show($field = null)
  {
    if ($field)
    {
      $this->db->select($field);
    };
    return $this->db->get($this->table, $this->limit);
  }

  public function filter($data = array())
  {
    if(!empty($this->input)) {
    //save temporary because data will replace
    //with filter field
    // $this->tmp['original'] = $this->get_data(); //cara agar tdk tertimpa
    //filter with filter field
    foreach($data as $key => $field) {
      $arr[$field] = $this->input[$field];
    };
    //show selected field
    return $arr;
    // $this->tmp[$this->table] = $arr;
    // return $this;
    } else throw new Exception('Data is unavailable');
  }

  public function hasOne($table)
  {
    $this->table = $table;
    return $this;
  }

  //set if id is exists, if not !isset($id) will get last id row()
  public function check_id()
  {
    if (!empty($this->get_data())) {
      $id = $this->search_row('id')->row_array('id');
    } else {
      $id = $this->show('id')->last_row('array');
    };
    $this->set_data(array(
      'id'  =>  $id['id'],
    ));
    // return $this->db->last_query();
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

  //output CI_DB_Result
  protected function custom_qry($sql, $bind = array())
  {
    return $this->db->query($sql, $bind);
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
      return $this->show($fields);
  }
}
