<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

//default with access 755
define('KEYPATH', APPPATH.'.env'.DIRECTORY_SEPARATOR);

use \ParagonIE\Halite\KeyFactory;
use \ParagonIE\Halite\Password;
use \Firebase\JWT\JWT;

class OpenSecurity
{
  private $_keypair;
  private $db;

  public $username;
  public $password;
  public $apikey;

  //get from database object from controller
  public function load_object(Object $db)
  {
    $this->db = $db;
  }

  // private function _secret()
  // {
  //   if (is_empty($this->db->secretkey)) {
  //     throw new Exception('Empty Auth secret')
  //   };
  //   return $this->db->secretkey;
  // }

  // private function _sym_enc_key()
  // {
  //   return  KeyFactory::generateEncryptionKey($this->secret);
  // }
  //
  // private function _sym_auth_key()
  // {
  //   return KeyFactory::generateAuthenticateKey($this->secret);
  // }

  public function hash($string)
  {
    return Password::hash($string, $this->db->secretkey);
  }

  public function check_hash($string, $stored_hash)
  {
    return Password::verify($string, $stored_hash, $this->db->secretkey) ;
  }

  // trigger with signup or reset password
  private function _enc_keypair()
  {
    $this->_keypair = KeyFactory::generateEncryptionKeyPair($this->password);
    return $this;
  }

  public function refresh()
  {
    $this->_enc_keypair();
  }

  //access only from _enc_keypair
  public function get_secret()
  {
    return $this->_keypair->getSecretKey();
  }
  //access only from _enc_keypair
  public function get_public()
  {
    return $this->_keypair->getPublicKey();
  }

  public function save_key()
  {
    $message = json_encode(array(
      'enc_key' =>  $this->_sym_enc_key(),
      'auth_key'  =>  $this->_sym_auth_key(),
    ));
    KeyFactory::save($message, KEYPATH.trim($this->hash($this->user).'.key'));
  }
}

class OpenToken extends OpenSecurity
{
  protected $CI;
  protected $_config;
  private $_header = array();
  private $_payload = array();

  public $request_token = '';

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->config = $this->CI->config->item('openauth');
  }

  // Please dont forget add JTI header with double quote
  public function set_header($header = array())
  {
    $this->_header = array_merge(array(
      "iss" =>  $this->_config['issuer'],
      "aud" =>  $this->_config['audience'],
      "iat" =>  time(),
      "jti" =>  $this->CI->session->userdata('tokens'), //fill from form_input
      "nbf" =>  time() + $this->config['int_before'],
      "exp" =>  time() + $this->_config['int_expire'],
    ), $header);
  }

  public function set_payload($payload = array())
  {
    $this->_payload = $payload;
  }

  private function _get_payload()
  {
    return $this->_payload;
  }

  private function _build_up()
  {
    return array_merge($this->_header, array(
      "data"  =>  $this->_payload
    ));
  }

  public function encode_token()
  {
    return JWT::encode($this->_build_up(), $this->_secret());
  }

  public function decode_token()
  {
    $this->extract = (array) JWT::decode($this->_token, $this->_secret(), array('HS256'));
  }

  protected function extract_data()
  {
    return $this->extract['data'];
  }
  //check if same as session['token']
  protected function extract_jti()
  {
    return $this->extract['jti'];
  }

  protected function extract_exp()
  {
    return $this->extract['exp'];
  }
}

/*
 * todo : - check that jti came from session
 */
class Openauth extends OpenToken
{
  private $db;

  public function __construct()
  {
    parent::__construct();
  }

  public function check_login()
  {
    return ($this->db->uname == $this->username && $this->check_hash($this->password, $this->db->upass));
  }

  public function check_api()
  {
    return ($this->db->secretkey == $apikey) ;
  }

  public function new_login()
  {
    $this->refresh();
    $this->save_key();
    return array(
      'uname' =>  $this->username,
      'upass' =>  $this->hash($this->password),
      'secretkey' =>  $this->get_secret(),
      'publickey' =>  $this->get_public(),
    );
  }

}
