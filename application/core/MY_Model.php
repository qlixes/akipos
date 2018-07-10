<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('PAGE_PER_PAGE', 44);

use \Ramsey\Uuid\Uuid;

interface IModel{
  public function findAll();
  public function findBy($key = array());
  public function registration();
  public function findAndUpdate($key = array());
  public function findAndRemove($key = array());
  // public function findNext();
  // public function findPrevious();
  // public function findFirst();
  // public function findLast();
}

class MY_Model extends CI_Model
{
  private $data = array();
  private $limit;
  private $offset;

  //from controller input data
  //for m-m / 1-m
  public $input = array();

  //list table field
  protected $field = array();

  protected $table;
  protected $temp;

  protected $id = null;

  protected $password = '';

  public function __construct()
  {
    parent::__construct();
    $this->offset = 0;
    $this->limit = $this->config->default_cfg(PAGE_PER_PAGE, 20);
  }

  //merge array into old array
  //for edit,insert
  protected function set_data($data = array(), $reset = false)
  {
    //if old data is empty
    if ($reset)
      $this->data = array();
    $this->data = array_merge($this->data, $data);
    return $this;
  }

  protected function get_data()
  {
    return $this->data;
  }

  protected function add()
  {
    $this->db->insert($this->table, $this->get_data());
    return $this;
  }

  protected function edit()
  {
    $this->db->update($this->table, $this->get_data());
    return $this;
  }

  protected function erase()
  {
    $this->db->delete($this->table, $this->get_data());
    return $this;
  }
  //check before hasOne
  protected function check_id()
  {
    $this->id = $this->show_full($this->get_data())
                     ->show('id')
                     ->row_array()['id'];
  }

  protected function show($field = null, $sort = null)
  {
    if ($field)
      $this->db->select($field);
    if ($sort)
      $this->db->order_by($sort);
    //hasOne has execute
    if (isset($this->tmp)) {
      $table = $this->table;
      $this->table = $this->tmp;
    } else {
      $table = $this->table;
    };
    return $this->db->get($table, ($this->offset * $this->limit), $this->limit);
  }

  // protected function next_result()
  // {
  //   $this->offset = $this->offset + 1;
  //   return $this;
  // }
  //
  // protected function previous_result()
  // {
  //   if ($this->offset > 0) {
  //     $this->offset = $this->offset - 1;
  //   };
  //   return $this;
  // }
  // protected function first_result()
  // {
  //   $this->offset = 0;
  //   return $this;
  // }
  //
  // protected function last_result()
  // {
  //   $total_rows = $this->db->get($this->table)->num_rows();
  //   $this->offset = ($total_rows > $this->limit) ? round(($total_rows % $this->limit), 0, PHP_ROUND_HALF_DOWN) : 0 ;
  //   return $this;
  // }

  // extract input as filter field only
  protected function filter($index)
  {
    if(!empty($this->input)) {
      foreach($this->field[$index] as $key => $field) {
        $arr[$field] = $this->input[$field];
      };
      //show selected field
      // return $arr;
      $this->set_data($arr, true);
      return $this;
    } else show_error('Data is unavailable');
  }

  //like
  protected function show_part($cond = array(), $or = array())
  {
    $this->db->like($cond);
    if (!empty($or))
      $this->db->or_like($or);
    return $this;
  }

  //where
  protected function show_full($cond = array(), $or = array())
  {
    $this->db->where($cond);
    if (!empty($or))
      $this->db->or_where($or);
    return $this;
  }

  //output CI_DB_Result
  protected function custom_qry($sql, $bind = array())
  {
    return $this->db->query($sql, $bind);
  }

  //alternate join
  //result will join array with parent table
  //for select will using stored procedure
  //for insert,edit,delete
  protected function hasOne($table, $cond = array())
  {
    $this->tmp = $this->table;
    $this->table = $table;
    return $this->show_full($cond);
  }

  protected function stored_procedure($proc_name, $bind = array())
  {
    return $this->db->query("CALL `$proc_name`", $bind);
  }

  protected function stored_function($func_name, $bind = array())
  {
    return $this->db->query("SELECT `$func_name`", $bind);
  }

  //$replace must = array('key_replace' => array('key_new'  => $data))
  // Implementation :
  // return $this->single_array($this->show()->result(), array(
  //   'city_id' =>  array(
  //     'city'  =>  array('id'  =>  1,'store_code'  =>  'coba')
  //   ),
  //   'province_id' =>  array(
  //     'province'  =>  array('id'  =>  1, 'province_code'  =>  'SBY')
  //   )
  // ));
  protected function single_array($data = array(), $replace = array())
  {
    foreach($replace as $key => $value) {
      //remove old key as  filter
      unset($data[$key]);
      //get new key
      $data =  array_merge($data, $value);
    };
    return $data;
  }

  protected function get_uuid()
  {
    $uuid = Uuid::uuid1();
    return $uuid->serialize();
  }
}
