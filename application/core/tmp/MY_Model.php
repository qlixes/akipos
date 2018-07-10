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
    $this->db->insert($this->table, $this->get_data());
    echo $this->db->last_query();
    return $this;
  }

  public function edit()
  {
    $this->db->update($this->table, $this->get_data());
    echo $this->db->last_query();
    return $this;
  }

  public function erase()
  {
    $this->db->delete($this->table, $this->get_data());
    echo $this->db->last_query();
    return $this;
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
    foreach($data as $key => $field) {
      $arr[$field] = $this->input[$field];
    };
    //show selected field
    return $arr;
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
    return $this;
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

/**
 *   Implementasi

  * $this->users_model->input = array(
  *    'id_role' =>  '1',
  *    'uname'   =>  'sysbot1',
  *    'upass'   =>  'sysbot1',
  *    'secretkey' =>  '-',
  *    'publickey' =>  'crud',
  *    'fullname'  =>  'Mr. Bot',
  *    'email'   =>  'kontol@anjing',
  *    'fb_id'   =>  '-',
  *    'tweet_id'  =>  'fuckup',
  *    'gplus_id'  =>  'jancok',
  *    'blog'  => '-',
  *  );
  *  $parent = $this->users_model->filter(array('id_role', 'uname', 'upass', 'secretkey','publickey'));
  *  //set parent for getting id, then reset for id_parent
  *  $this->users_model->set_data($parent)->erase()->check_id();
  *  // $this->users_model->set_data($parent)->check_id()->edit();
  *  $child = $this->users_model->hasOne('users_profile')
  *                             ->filter(array('email', 'fb_id', * 'tweet_id', 'gplus_id', 'blog'));
  *  $this->users_model->set_data($child, false)->erase();
 */
