<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

define('KEYPATH', APPPATH.'.env'.DIRECTORY_SEPARATOR);
define('AUTH_ISSUER', 46);
define('AUTH_AUDIENCE', 47);
// define('', 48);
// define('', 49);
// define('', 50);
// define('', 51);
// define('', 52);

class MY_Security extends CI_Security
{
  public $container;

  protected $passLib;

  public function __construct()
  {
    parent::__construct();

    $this->container = new \Pimple\Container();

    $this->container['NewTokenSigner'] = $this->container->factory(function($c) {
      return new \Lcobucci\JWT\Signer\Hmac\Sha512();
    });

    $this->container['NewCaptchaBuilder'] = $this->container->factory(function($c) {
      return new \Gregwar\Captcha\CaptchaBuilder();
    });

    $this->container['NewEncKeyPair'] = $this->container->factory(function ($c) {
      $keypair = \ParagonIE\Halite\KeyFactory::generateEncryptionKeyPair();
      $c['NewSecretKey'] = $keypair->getSecretKey()->get();
      $c['NewPublicKey'] = $keypair->getPublicKey()->get();
    });

    $this->container['NewPasswordLib'] = $this->container->factory(function ($c) {
      return new \PasswordLib\PasswordLib();
    });
  }

  /**
   * @param string $key
   * @param boolean $useBase64
   * @return object
   */
  public function load($key, $useBase64 = false)
  {
    $result = $this->container[$key];
    if ($useBase64)
      $result = base64_encode($result);
    return $result;
  }

  /**
   * @param uuid string
   * @return void
   */
  public function initUUID($uuids = null)
  {
    $this->container['SessionUUID'] = $this->container->factory(function($c) use ($uuids){
      $uuid = \Ramsey\Uuid\Uuid::Uuid1();
      return ($uuids) ? $uuids : $uuid->serialize();
    });
    return $this;
  }

  private function validateToken($issuer, $audience)
  {
    $this->container['SessionValidate'] = $this->container->factory(function($c) use(
      $issuer, 
      $audience
    ) {
      return (new \Lcobucci\JWT\ValidationData())->setIssuer($issuer)
                                   ->setAudience($audience)
                                   ->setId($c['SessionUUID']);
    });
    return $this;
  }

  public function wrapToken($issuer, $audience, $expires = 600, $notBefore = 60)
  {
    $this->container['SessionToken'] = $this->container->factory(function($c) use (
      $issuer,
      $audience,
      $notBefore,
      $expires
    ) {
      return (new \Lcobucci\JWT\Builder())->setIssuer($issuer)
                                          ->setAudience($audience)
                                          ->setIssuedAt(time())
                                          ->setNotBefore(time() + $notBefore)
                                          ->setExpiration(time() + $expires)
                                          ->setId($c['SessionUUID'], true)
                                          ->set('data', $c['SessionData'])
                                          ->sign($c['NewTokenSigner'], $c['SessionKey'])
                                          ->getToken();
    });
    return $this;
  }

  /**
   * @param array $payloads
   * @return void 
   */
  public function initPayloads($payloads = array())
  {
    $this->container['SessionData'] = $payloads;
    return $this;
  }

  /**
   * @param string $sessionKey
   * @return void
   */
  public function initSessionKey($sessionKey)
  {
    $this->container['SessionKey'] = $sessionKey;
    return $this;
  }

  /**
   * @param string $token
   * @return void 
   */
  public function claimToken($token)
  {
    $this->container['SessionVerify'] = $this->container->factory(function($c) use(
      $token) {
      $token = (new \Symfony\Component\Yaml\Parser())->parse((string) $token);
      if ($token->verify($c['NewTokenSigner'], $c['SessionKey']) && $token->validate_token($c['SessionUUID'])) {
        $c['SessionData'] = $token->getClaim('data');
      };
    });
    return $this;
  }

  /**
   * @param string $text
   * @return void
   */
  public function writeHash($text, $mode = '$2a$',$cost = 12)
  {
    $this->container['NewHash'] = $this->load('NewPasswordLib')->createPasswordHash($text, $mode, array(
      'cost'  =>  $cost
    ));
    return $this;
  }

  /**
   * @param string  $hashed
   * @return void
   */
  public function checkHash($hashed)
  {
    $this->container['VerifyHash'] = $this->load('NewPasswordLib')->verifyPasswordHash($his->load('NewHash'), $hashed);
    return $this;
  }

  /** 
   * Respect Validation
   * @param string $input
   * @return string
   */
  // public function fUsername()
  // public function fPassword()
  // public function fEmail()
  // public function fNumber()
  // public function fDouble()
  // public function fDate()
  // public function fFullname()
}