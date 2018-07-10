<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

/**
* Model client should return itself result
**/

class Users_model extends MY_Model implements IModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';

        $this->load->library('Openauth');
    }

    public function set_username($username)
    {
        $this->set_data(array(
            'username'  => $username
        ));
        return $this;
    }

    public function set_password($password)
    {
        $_userthis->set_data(array(
            'password'  => ''
        ));
        return $this;
    }
}