<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Gregwar\Captcha\CaptchaBuilder;

class Opencaptcha extends CaptchaBuilder
{
    private $text;

    public function show_captcha($uuid)
    {
      $this->build(KEYPATH."$uuid.jpg");
      $this->text = $this->getPhrase();
    }
  
    public function check_captcha($text)
    {
      return ($this->text === $text);
    }
}