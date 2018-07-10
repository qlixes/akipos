<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
  private $data = array();

  protected $table;

  protected $status = false;

  public $id;

  public function __construct()
  {
      parent::__construct();
      // $this->load->database();
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

  // public function add()
  // {
  //   if ($this->db->insert($this->table, $this->get_data())) {
  //     //after insert will getting last id
  //     $this->id = $this->search_id(get_data())->id;
  //   } else throw new Exception('Could not insert');
  // }

  // public function add()
  // {
  //   if(!$this->db->insert($this->table, $this->get_data())) {
  //     throw new Exception('Could not add !');
  //   };
  //   return $this->show();
  // }

  // public function edit()
  // {
  //   // $this->db->set($this->get_data())->insert($this->table);
  //   if(!$this->db->replace($this->table, $this->get_data())) {
  //     throw new Exception('Could not update !');
  //   };
  // }
  //
  // public function erase()
  // {
  //   if(!$this->db->delete($this->table, $this->get_data())) {
  //     throw new Exception('Could not erase !');
  //   };
  // }
  // 

  public function show($field = null, $limit = 20)
  {
    if ($field)
    {
      $this->db->select($field);
    };
    return $this-db->get($this->table, $limit);
  }

  public function is_exists($check = array())
  {
    if (!is_empty($check)) {
      $this->set_data($check, true);
    };
    $this->showFull();
    return ($this->show()->num_rows() >= 1);
  }

  // public function show($field = null, $limit = 20)
  // {
  //   if ($field) {
  //     $this->db->select($field);
  //   };
  //   $this->db->limit($limit);
  //   $query = $this->db->get($this->table);
  //   return $query;
  // }

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

  public function search_id($where = array())
  {
    $this->set_data(array($where);
    $this->showFull();
    return $this->show()->row();
    // return $object->id;
  }

  protected function custom_qry($sql, $bind = null)
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

  // must finished collection
  protected function hasOne($table, $data = array())
  {
    $this->table = $table;
    if (!is_empty($data)) {
      $this->set_data($data, true);
    };
    return $this;
  }
}
