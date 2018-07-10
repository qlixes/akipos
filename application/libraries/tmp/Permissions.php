<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

use Pimple/Container;

class  Openpermission
{
  private $CI;
  private $container;
  private $permission; //as container
  //load on helper folder
  public function __construct()
  {
    $this->CI =& get_instance();
    $this->container = new Container();
  }

  public function add_permission($id_role, $helper)
}
