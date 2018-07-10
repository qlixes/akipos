<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta_model extends MY_Model implements IModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'meta';
    }

    public function set_meta($meta)
    {
        $this->set_data(array(
            'names' => $meta
        ));
        return $this;
    }
}