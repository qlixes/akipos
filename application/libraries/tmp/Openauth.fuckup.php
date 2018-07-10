<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

//default with access 755
define('KEYPATH', APPPATH.'.env'.DIRECTORY_SEPARATOR);

use \Defuse\Crypto\Key;
use \Lcobucci\JWT\Builder;
use \Lcobucci\JWT\ValidationData;
use \Lcobucci\JWT\Parser;
use \Lcobucci\JWT\Signer\Hmac\Sha512;


class OpenSecurity
{
  private $key;

  public $saltKey;
  public $secureKey; //secretKey
  public $activeKey;
  public $forgetKey;
  public $apiKey; //publicKey
  public $password;

  public function once_time($password)
  {
    $this->saltKey = base64_encode(Key::createNewRandomKey()->saveToAsciiSafeString());
    return array(
      $this->saltKey,
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

  public $builder;

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
}

class Openauth extends OpenJWT
{
  public $jti;
}
