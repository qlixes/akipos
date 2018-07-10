<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('PAGE_PER_PAGE', 44);

class MY_Model extends CI_Model
{
  private $data = array();
  private $tmp = array();

  protected $table;
  protected $status = false;

  private $old_object;

  protected function __construct()
  {
    parent::__construct();
  }

  //merge array into old array
  protected function set_data($data = array(),$reset = false)
  {
    if ($reset) {
      $this->data = null;
    }
    $this->data = array_merge($data, $this->data);
  }

  private function get_data()
  {
    return $this->data;
  }

  protected function add()
  {
    return $this->db->insert($this->table, $this->get_data());
  }

  protected function edit()
  {
    return $this->db->replace($this->table, $this->get_data());
  }

  protected function erase()
  {
    return $this->db->delete($this->table, $this->get_data());
  }

  protected function show($field = null)
  {
    if ($field)
    {
      $this->db->select($field);
    };
    return $this->db->get($this->table, $this->config->default_cfg(PAGE_PER_PAGE, 20));
  }

  //filter for $this->data
  // separator field data foreach table

  /**
   * filter used field foreach other join table
   * @param  array  $field take join table's field
   * @return integer  get join table's id
   */
  protected function filter($fields = array())
  {
    try {
      if(!empty(this->get_data())) {
        $this->tmp['original'] = $this->get_data();
        //parsing filter only needed field selected
        //from $this->get_data();
        foreach($fields as $key => $field) {
          $arr[$field] = $this->tmp['original'][$field];
        };
        //fill foreach table with their own field
        $this->tmp[$this->table] = $arr;
        // //set where
        // $this->set_data($this->tmp[$this->table],true);
        // //logical will result only row()
        // $this->old_object = $this; //return object
      }
    } catch (Exception $e) {
      show_error(htmlspecialchars_decode($e->getMessage()), 500, 'Model Exception');
    };
  }

  //reset into default begin
  protected function reset_data()
  {
    $this->tmp['original'] = null;
    $this->set_data(array());
  }

  protected function filter_result()
  {
    $this->set_data($this->tmp[$this->table], true);
    return $this->search_row();
  }

  // @data array list of field needed
  // TODO : separator for multiple as filter does
  protected function hasOne($table, $data = array())
  {
    // check on parent's filter()
    $this->set_data($this->tmp[$this->table], true);
    //id is exists
    if ($this->search_row()->num_rows() == 1) {
      $this->set_data(array('id' => $this->search_row()->row()->id), true);
      $this->table = $table;
      $this->filter($data);
      return $this;
    } else throw new Exception('Parent does not exits');
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

  protected function set_active($yes = true)
  {
    $this->set_data(array(
      'is_active' => ($yes) ? 1 : 0,
    ));
    $this->edit();
  }

  protected function search_list($fields = null)
  {
      $this->showPartial();
      return $this->show($fields);
  }

  protected function search_row($fields = null)
  {
      $this->showFull();
      //return object
      return $this->show($fields);
  }
}
