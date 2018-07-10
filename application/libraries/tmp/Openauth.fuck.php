<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

//default with access 755
define('KEYPATH', APPPATH.'.env'.DIRECTORY_SEPARATOR);

use \ParagonIE\Halite\KeyFactory;
use \ParagonIE\Halite\Password;
use \Lcobucci\JWT\Builder;
use \Lcobucci\JWT\ValidationData;
use \Lcobucci\JWT\Parser;
use \Lcobucci\JWT\Signer\Hmac\Sha512;


class OpenSecurity
{
  private $keypair;

  public $saltKey;
  public $secureKey; //secretKey
  public $activeKey;
  public $forgetKey;
  public $apiKey; //publicKey
  public $sessionID;

  //for once_time use
  protected function get_secretKey()
  {
    // $this->secureKey = base64_encode($this->keypair->getSecretKey()->get());
    // $this->secureKey = base64_encode($this->keypair->getSecretKey()->get());
    return $this;
  }

  protected function get_publicKey()
  {
    // $this->apiKey = base64_encode($this->keypair->getPublicKey()->get());
    return $this;
  }

  //password using plaintext
  protected function _one_time_keypair()
  {
    $this->saltKey = base64_encode(openssl_random_pseudo_bytes(32));
    $keypair = KeyFactory::generateEncryptionKeyPair();
    // $this->secureKey = base64_encode($keypair->getSecretKey()->get());
    // $this->apiKey = base64_encode($keypair->getPublicKey()->get());
    return $this;
  }

  // protected function save_encKey()
  // {
  //   $encKey = KeyFactory::generateEncryptionKey($this->secureKey);
  //   KeyFactory::save($encKey, KEYPATH.$this->secureKey.'.key');
  //   return $this;
  // }

  protected function get_authKey()
  {
    $this->activeKey = base64_encode(KeyFactory::generateAuthenticationKey($this->secureKey)->get());
    return $this;
  }

  protected function get_encKey()
  {
    $this->forgetKey = base64_encode(KeyFactory::generateEncryptionKey($this->secureKey)->get());
    return $this;
  }

  public function hash($string)
  {
    return Password::hash($string, $this->secureKey);
  }

  public function is_match($string, $stored)
  {
    return Password::verify($string, $stored, $this->secureKey);
  }

  // protected function save_authKey()
  // {
  //   $authKey = KeyFactory::generateAuthenticationKey($this->secureKey);
  //   KeyFactory::save($authKey, KEYPATH.$this->secureKey.'.auth');
  //   return $this;
  // }

  // public function load_authKey()
  // {
  //   return KeyFactory::loadAuthenticationKey(KEYPATH.$this->secureKey.'.auth');
  // }
  //
  // public function load_encKey()
  // {
  //   return KeyFactory::loadEncryptionKey(KEYPATH.$this->secureKey.'.key');
  // }

  public function session_id()
  {
    // $this->sessionID = KeyFactory::deriveEncryptionKey($password, $salt);
  }

  public function test()
  {
    $keypair = KeyFactory::generateEncryptionKeyPair();
    return array(
      base64_encode($keypair->getSecretKey()->get()),
      $keypair->getPublicKey()->get()
    );
  }
}

// @iss The issuer of the token
// @sub The subject of the token
// @aud The audience of the token
// @exp Expiration in NumericDate value
// @nbf Configures the time that the token can be used
// @iat Configures the time that the token was issue
// @jti Unique identifier for jwt
class OpenJWT extends OpenSecurity
{
  /**
   * need to completed :
   * - setIssuer
   * - setAudience
   * - setId #jti claim
   * - setIssuedAt #iat claim
   * - setNotBefore #nbf claim
   * - set #new payload for data
   * @param  string $secretKey The secretKey on database
   * @return object
   */
  public function build($maxTime = 300)
  {
    //sign  creates a signature using "secretkey" as key
    $this->builder = (new Builder())->setIssuedAt(time())
                          ->setNotBefore(time() + 60)
                          ->setExpiration(time() + maxTime);
  }

  public function get_token()
  {
    $signer = new Sha512();
    return $this->builder->setId($this->publicKey,true)
                         ->sign($signer, $this->secureKey)
                         ->getToken(); //output string
  }

  public function get_access()
  {
    return (new Parser())->parse((string) $this->get_token());
  }

  public function check_token()
  {}

  //change all public, secret, enckey, authkey
  public function once_time()
  {
    //automate getting public & secret
    $this->_one_time_keypair()->get_secretKey()
                              ->get_publicKey()
                              ->get_encKey()
                              ->get_authKey();
                              // ->save_authKey()
                              // ->save_encKey();
  }
}

class Openauth extends OpenJWT
{
}
