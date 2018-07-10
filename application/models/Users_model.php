<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * child class must read for set_data($field=>$value)
 */
class Users_model extends MY_Model implements IModel
{
  protected $table = 'users';

  public function __construct()
  {
    parent::__construct();
    $this->field['users'] = array('role_id', 'uname', 'upass', 'is_enable');
    $this->field['users_profile'] = array('fullname','email','image_profile','facebook_id','twitter_id','gplus_id','blog_id');
    $this->field['users_store'] = array('store_id');
  }

  public function registration()
  {
    $this->openauth->once_time();
    $this->filter('users')->set_data(array(
      'upass' =>  $this->hashing(),
      'secure_code' =>  $this->openauth->secureKey,
      'api_code'  =>  $this->openauth->apiKey,
    ))->add()->check_id();
    $this->hasOne('users_profile')->filter('users_profile')
                                  ->set_data(array('id' =>  $this->id))
                                  ->add();
    $this->hasOne('users_store')->filter('users_store')
                                ->set_data(array(
                                  'users_id' => $this->id,
                                  'is_default' => 1,
                                ))
                                ->add();
  }

  public function findAll()
  {
    foreach ($this->show('id, uname, secure_code, api_code, is_enable, role_id')->result('array') as $row) {
      $result[] = $this->single_array($row, array(

        'role_id' =>  array(
          'role'  =>  $this->hasOne('roles', array(
            'id'  =>  $row['role_id']
          ))->show('id, role_name')->result('array'),
        ),

        'profile_id'  =>  array(
          'profile' =>  $this->hasOne('users_profile', array(
            'id'  =>  $row['id'],
          ))->show('fullname, email, image_profile, facebook_id, twitter_id, gplus_id, blog_id')->result('array')
        ),

        'store_id' => array(
          'store' => $this->hasOne('users_store', array(
            'users_id' => $row['id'],
          ))->show('store_id')->result_array(),
        ),
      ));
    }
    return $result;
  }

  public function findBy($key = array())
  {
    foreach ($this->show_full($key)->show('id, uname, secure_code, api_code, is_enable, role_id')->result('array') as $row) {
      $result[] = $this->single_array($row, array(

        'role_id' =>  array(
          'role'  =>  $this->hasOne('roles', array(
            'id'  =>  $row['role_id']
          ))->show('id, role_name')->result('array'),
        ),

        'profile_id'  =>  array(
          'profile' =>  $this->hasOne('users_profile', array(
            'id'  =>  $row['id'],
          ))->show('fullname, email, image_profile, facebook_id, twitter_id, gplus_id, blog_id')->result('array')
        ),

        'store_id' => array(
          'store' => $this->hasOne('users_store', array(
            'users_id' => $row['id'],
          ))->show('store_id')->result_array(),
        ),
      ));
    }
    return $result;
  }

  public function findAndUpdate($key = array())
  {
    $this->openauth->once_time();
    $this->filter('users')->set_data(array(
      'upass' =>  $this->openauth->create_hash($this->input['upass']),
      'secure_code' =>  $this->openauth->secureKey,
      'api_code'  =>  $this->openauth->apiKey,
    ))->show_full($key)->edit()->check_id();

    $this->hasOne('users_profile', array(
      'id' =>  $this->id
    ))->filter('users_profile')->edit();

    $this->hasOne('users_store',array(
      'users_id' => $this->id
    ))->filter('users_store')->edit();
  }

  public function findAndRemove($key = array())
  {
    $this->show_full($key)->erase()->check_id();
    $this->hasOne('users_profile', array('id' =>  $this->id))->erase();
    $this->hasOne('users_store', array('users_id' => $this->id))->erase();
  }
  // for special case underdog user with high user permissions (correction)
  public function authenticate()
  {
  }

  public function authorization()
  {
  }

  public function login()
  {}

  public function logout()
  {}

  // public function roles()
  // public function permissions()
  // public function activation()
  // public function reminder()
  // public function throttle()
  // public function checkpoints()

  public function hashing()
  {
    return $this->openauth->create_hash($this->input['upass']);
  }

}
