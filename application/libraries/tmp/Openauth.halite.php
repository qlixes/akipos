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

  private $hashKey;

  //password using plaintext
  protected function _one_time_keypair()
  {
    $this->saltKey = base64_encode(openssl_random_pseudo_bytes(32));
    $this->keypair = KeyFactory::generateEncryptionKeyPair();
    // $this->keypair = $keypair;
    return $this;
  }

  public function get_secureKey()
  {
    $this->secureKey = base64_encode($this->keypair->getSecretKey()->get());
    return $this;
  }

  public function get_apiKey()
  {
    $this->apiKey = base64_encode($this->keypair->getPublicKey()->get());
    return $this;
  }

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

  protected function get_hashKey()
  {
    $this->hashKey = KeyFactory::generateEncryptionKey();
    return $this;
  }

  protected function hash($string)
  {
    return Password::hash($string, $this->hashKey);
  }

  protected function is_match($string, $stored)
  {
    return Password::verify($string, $stored, $this->hashKey);
  }

  // public function test()
  // {
  //   $keypair = KeyFactory::generateEncryptionKeyPair();
  //   return array(
  //     base64_encode($keypair->getSecretKey()->get()),
  //     bin2hex($keypair->getPublicKey()->get())
  //   );
  // }
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
    $this->_one_time_keypair()->get_encKey()
                              ->get_authKey()
                              ->get_secureKey()
                              ->get_apiKey()
                              ->get_hashKey();
  }
}

class Openauth extends OpenJWT
{
  public $jti;
}
