<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Store_model extends MY_Model implements IModel
{
  protected $table = 'store';

  public function __construct()
  {
    parent::__construct();
    $this->field['store'] = array('store_code', 'store_name', 'store_address', 'store_phone', 'province_id', 'city_id', 'is_enable');
  }

  public function registration()
  {
    $this->filter('store')->add();
  }

  public function findAndRemove($key = array())
  {
    $this->show_full($key)->erase();
  }

  public function findAndUpdate($key = array())
  {
    $this->filter('store')->show_full($key)->edit();
  }

  public function findAll()
  {
    foreach ($this->show()->result('array') as $row) {
      $result[] = $this->single_array($row, array(
        'city-id' =>  array(
          'city'  =>  $this->hasOne('city', array(
            'id'  =>  $row['city_id']
          ))->show('id, city_code, city_name')->row_array()
        ),
        'province_id' =>  array(
          'province'  =>  $this->hasOne('province', array(
            'id'  =>  $row['province_id']
          ))->show()->row_array()
        ),
      ));
    }
    return $result;
  }

  public function findBy($key = array())
  {
    foreach ($this->show_full($key)->show()->result('array') as $row) {
      $result[] = $this->single_array($row, array(
        'city-id' =>  array(
          'city'  =>  $this->hasOne('city', array(
            'id'  =>  $row['city_id']
          ))->show('id, city_code, city_name')->row_array()
        ),
        'province_id' =>  array(
          'province'  =>  $this->hasOne('province', array(
            'id'  =>  $row['province_id']
          ))->show()->row_array()
        ),
      ));
    }
    return $result;
  }
}
