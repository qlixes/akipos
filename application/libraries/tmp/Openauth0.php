<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

//default with access 755
define('KEYPATH', APPPATH.'.env'.DIRECTORY_SEPARATOR);

use \Defuse\Crypto;
use \Defuse\Crypto\Key;
use \Defuse\Crypto\KeyProtectedByPassword;
use \Firebase\JWT\JWT;

/**
 * - object $username & password changed from array into object
 */
class Openauth
{
    private $CI;
    private $_config = array();
    private $_data = array();

    // token key foreach user has on .key
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->_config = $this->CI->config->item('openauth');
    }

    private function _hash($plaintext)
    {
      return Crypto::encrypt($plaintext, $this->_salt);
    }

    private function _firebase_jwt()
    {
      // get time while execute
      return array(
        "iss" =>  $this->_config['issuer'],
        "aud" =>  $this->_config['audience'],
        //timestamp of token issue
        "iat" =>  time(),
        //unique string validate token
        "jti" =>  $this->_uuid_token(),
        //validate timestamp token
        "nbf" =>  time() + $this->_config['int_before'],
        //timestamp
        "exp" =>  time() + $this->_config['int_expire'],
        "data"  =>  $this->payload,
      )
    }

    // list any data inside tokenn
    public function set_payload($payload = array())
    {
      $this->payload = array_merge($this->payload, $payload);
      return $this;
    }

    //all input must be encode base64 on input form at controller
    public function set_login($username, $password)
    {
        //filter input
        $this->_username = $username;
        $this->username = $this->_hash($username);
        $this->password = $this->_hash($password);
    }

    // salt_hash
    // save on db
    private function _salt()
    {
        $salt = Key::createNewRandomKey();
        $this->_salt = $salt->saveToAsciiSafeString();
    }

    private function _uuid_token()
    {
      // return base64_encode(mcrypt_create_iv(32));
      return bin2hex(openssl_random_pseudo_bytes(64));
    }

    // // get from .key
    // public function set_locked_data($locked_data)
    // {
    //   $this->locked_data = $locked_data;
    //   return $this;
    // }

    // save on db
    // get cipher $data
    // better use on session and save on file .key
    public function lock_data()
    {
      // createrandomprotected with protected $password
      $data = KeyProtectedByPassword::createRandomPasswordProtectedKey($this->password);
      $this->cipher = $data->saveToAsciiSafeString(),
      return $this;
    }

    // get plain $data
    // unlock with getting $password
    public function unlock_data()
    {
      $this->lock_data();
      try {
        $data = KeyProtectedByPassword::loadFromAsciiSafeString($this->cipher);
        //$this->password get while input username+password
        $this->plain = $data->unlockKey($this->password);
        //harus dirubah
        if ($this->plain === $this->cipher) {
          return true;
        };
      } catch (Exception $e) {
        $this->CI->show_error($e->getMessage());
      };
      return false;
    }
    // //only for username filename
    // private function set_key($key)
    // {
    //   $this->key = $this->_hash($key);
    //   return $this;
    // }

    private function read_key()
    {
      try {
        $this->cipher = file_get_contents($this->username.'.key');
      } catch (Exception $e) {
        $this->CI->show_error($e->getMessage());
      };
      return $this;
    }

    private function save_key()
    {
      try {
        $put = file_put_contents($this->username.'.key', $this->cipher);
      } catch (Exception $e)  {
        $this->CI->show_error($e->getMessage());
      };
      return $put !== false;
    }

    public function load_tbl($data = array())
    {
      //should has any value for requirement field
      try {
        //comparing hash only
        $this->password = $data['password'];
        $this->_salt = $data['salt'];
      } catch (Exception $e) {
        $this->CI->show_error($e->getMessage());
      };
    }
    //setiap action akan di kompress ke dlm token
    private function _get_token()
    {
      return JWT::encode($this->_firebase_jwt(), $this->plain, array('RS256'));
    }

    private function _open_token()
    {
      return JWT::decode($this->)
    }

    public function grant_token(){}

    public function read_payload()
    {
      return (array) $this->payload;
    }

    public function sign_up()
    {
      $this->_salt();
      $this->lock_data()->save_key();
      $this->set_payload(array(
        '_salt' =>  $this->_salt,
        'username'  =>  $this->_username,
        'password'  =>  $this->password,
      ));
    }

    public function sign_in()
    {
      //should load_tbl has data['username'] && data['password']
      if ($this->read_key()->unlock_data()) {
        //output token access
      }
    }
}
