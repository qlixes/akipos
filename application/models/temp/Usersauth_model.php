<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

class Usersauth_model extends MY_Model implements IModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users_auth';
    }

    public function set_user($id)
    {
        $this->set_data(array(
            'id'    => $id
        ));
        return $this;
    }

    public function set_salt($salt)
    {
        $this->set_data(array(
            'salt_key'    => $salt
        ));
        return $this;
    }

    public function set_access($token)
    {
        $this->set_data(array(
            'access_token'  => $token,
        ));
        return $this;
    }

    public function set_private($private)
    {
        $this->set_data(array(
            'private_key'   => $private
        ));
        return $this;
    }
}
