<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

/**
* Model client should return itself result
**/

class Roles_model extends MY_Model implements IModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'roles';
    }

    public function set_role($role)
    {
        $this->set_data(array('rolename' => $role));
        return $this;
    }
}