<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

use \Lcobucci\JWT\Builder;
use \Lcobucci\JWT\ValidationData;
use \Lcobucci\JWT\Parser;
use \Lcobucci\JWT\Signer\Hmac\Sha512;
use \Ramsey\Uuid\Uuid;

class OpenSecurity extends PasswordLib\PasswordLib
{
  public $secureKey; //secretKey
  public $apiKey; //publicKey

  public function once_time()
  {
    $keypair = \ParagonIE\Halite\KeyFactory::generateEncryptionKeyPair();
    $this->secureKey = base64_encode($keypair->getSecretKey()->get());
    $this->apiKey = base64_encode($keypair->getPublicKey()->get());
    return $this;
  }

  public function create_hash($password)
  {
    return $this->createPasswordHash($password, '$2a$', array(
      'cost' => 12
    ));
  }

  public function check_hash($password, $hashed)
  {
    return ($this->verifyPasswordHash($password, $hashed));
  }

  public function create_uuid()
  {
    return Uuid::uuid1();
  }
}

class Openauth extends OpenSecurity
{
  private $signer;
  
  // var issuedAt 
  private $iat;
  // var tokenId
  private $jti;
  // var serverName
  private $iss;
  // var notBefore
  private $nbf;
  // var expire
  private $exp;
  // var payload
  private $payloads = array();

  private $issuer;
  private $audience;
  private $secureCode;

  public function __construct($issuer, $audience)
  {
    $this->signer = new Sha512();
    $this->issuer = $issuer;
    $this->audience = isset($audience) ? $audience : $issuer;
  }
  /**
   * @param string $secure_code
   * @param array $payloads Payloads Body for send/receive
   * @param integer $expire
   * @param integer $notBefore
   * @return void
   */
  public function payloads($secureCode, $payloads = array(), $expire = 600, $notBefore = 60)
  {
    $this->iat = time();
    $this->jti = $this->create_uuid()->serialize();
    $this->iss = $this->iat + $notBefore;
    $this->exp = $this->iat + $expire;
    $this->payloads = $payloads;
    $this->secureCode = $secureCode;
    return $this;
  }

  /**
   * @param string $uuid Get from users_auth's uuid
   * @return boolean
   */
  private function validate_token($uuid)
  {
    return (new ValidationData())->setIssuer($this->issuer)
                                 ->setAudience($this->audience)
                                 ->setId($uuid);
  }

  /**
   * @param string $token
   * @param string $secure_code
   * @param string $uuid
   * @return array
   */
  public function read_token($token, $secureCode, $uuid)
  {
    $token = (new Parser())->parse((string) $token);
    if ($token->verify($this->signer, $secureCode) && $token->validate_token($uuid)) {
      return $token->getClaim('data');
    };
    return false;
  }

  /**
   * @param string $secure_code Get from user's secure_code
   * @return string
   */
  public function write_token()
  {
    return (new Builder())->setIssuer($this->issuer)
                          ->setAudience($this->audience)
                          ->setIssuedAt($this->iat)
                          ->setNotBefore($this->nbf)
                          ->setExpiration($this->exp)
                          ->setId($this->jti, true)
                          ->set('data', $this->payloads)
                          ->sign($this->signer, $secure_code)
                          ->getToken();
  }
}
