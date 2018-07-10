<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

class Category_model extends MY_Model implements IModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'category';
    }

    public function set_category($category)
    {
        $this->set_data(array(
            'labels'    => $category
        ));
        return $this;
    }
}