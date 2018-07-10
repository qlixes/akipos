<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Parser extends CI_Parser
{
  private $attribute = array();
  private $css = '<link rel="stylesheet" type="text/css" crossorigin="anonymous" ';
  private $js = '<script type="text/javascript" crossorigin="anonymous" ';

  public function __construct()
  {
    parent::__construct();
  }

  private function set_attribute($attribute = array(), $reset = false)
  {
    if ($reset) {
      $this->$attribute = array();
    };
    $this->attribute = array_merge($this->attribute, $attribute);
    foreach($this->attribute as $key => $value) {
      $result .= $key.'="'.$value.'" ';
    };
    return $result;
  }

  public function css($file, $params = array())
  {
    return $this->css .= $this->set_attribute($params, true).'>';
  }

  public function js($path, $param = array())
  {
    return $this->js .= $this->set_attribute($params, true).'></script>'
  }
}
