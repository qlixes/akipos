<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends MY_Model implements IModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'menu';
    }

    public function set_menu($menu)
    {
        $this->set_data(array(
            'labels'    => $menu
        ));
        return $this;
    }
}