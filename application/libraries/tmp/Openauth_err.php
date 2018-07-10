<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

//default with access 755
define('KEYPATH', APPPATH.'.env'.DIRECTORY_SEPARATOR);

use \ParagonIE\Halite\KeyFactory;
use \ParagonIE\Halite\Password;
use \Firebase\JWT\JWT;

class OpenSecurity
{
  private $_keypair;

  private $input = array();
  protected $secret;

  public function set_input($input = array())
  {
    $this->input = $input;
  }

  public function set_secret($secret)
  {
    $this->secret = $secret;
  }

  protected function _sym_enc_key()
  {
    return  KeyFactory::generateEncryptionKey($this->get_secret());
  }

  protected function _sym_auth_key()
  {
    return KeyFactory::generateAuthenticateKey($this->get_secret());
  }

  public function hash($string)
  {
    return Password::hash($string, $this->secret);
  }

  public function check_hash($string, $stored_hash)
  {
    return Password::verify($string, $stored_hash, $this->secret) ;
  }

  // trigger with signup or reset password
  private function _enc_keypair()
  {
    $this->_keypair = KeyFactory::generateEncryptionKeyPair($this->input['password']);
    return $this;
  }
  //access only from _enc_keypair
  private function fresh_secret()
  {
    return $this->_keypair->getSecretKey();
  }
  //access only from _enc_keypair
  private function fresh_public()
  {
    return $this->_keypair->getPublicKey();
  }

  protected function save_key()
  {
    $message = json_encode(array(
      'enc_key' =>  $this->_sym_enc_key(),
      'auth_key'  =>  $this->_sym_auth_key(),
    ));
    KeyFactory::save($message, KEYPATH.trim($this->hash($this->input['username']).'.key'));
  }
}

class OpenToken extends OpenHash
{
  protected $CI;
  protected $_config;
  private $_header = array();
  private $_payload = array();

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->config = $this->CI->config->item('openauth');
  }

  // Please dont forget add JTI header with double quote
  protected function _set_header($header = array())
  {
    $this->_header = array_merge(array(
      "iss" =>  $this->_config['issuer'],
      "aud" =>  $this->_config['audience'],
      "iat" =>  time(),
      // "jti" =>  , //fill from form_input
      "nbf" =>  time() + $this->config['int_before'],
      "exp" =>  time() + this->_config['int_expire'],
    ), $header);
  }

  protected function _set_payload($payload = array())
  {
    $this->_payload = $payload;
  }

  protected function _get_payload()
  {
    return $this->_payload;
  }

  private function _build_up()
  {
    return array_merge($this->_header, array(
      "data"  =>  $this->_payload
    ));
  }

  protected function _encode_token()
  {
    return JWT::encode($this->_build_up(), $this->_secret);
  }

  protected function _decode_token()
  {
    return (array) JWT::decode($this->_token, $this->_secret, array('HS256'));
  }

  public function set_token($token)
  {
    $this->_token = $token;
  }
}

class Openauth extends OpenToken
{
  public function __construct()
  {
    parent::__construct();
  }
}
