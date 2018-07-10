<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

define('ASSETS_JSPATH', 8);
define('ASSETS_CSSPATH', 9);
define('ASSETS_IMGPATH', 10);
define('ASSETS_UPLOADPATH', 11);
define('ASSETS_VIDEOPATH', 53);
define('ASSETS_FONTPATH', 45);
define('ASSETS_EDITORPATH', 5);
define('ASSETS_FAVICONS', 55);
define('ASSETS_PROFILEPATH', 56);
define('DATE_FORMAT', 63);
define('DATETIME_FORMAT', 65);
define('CURRENCY_FORMAT', 64);
define('PROFILER_ENABLE', 25);

interface IController
{
  public function synchronize($data = array());
}

class MY_Controller extends CI_Controller
{
  protected $controller;

  public function __construct()
  {
    parent::__construct();
    // $this->output->enable_profiler = (bool) $this->config->default_cfg(PROFILER_ENABLE, true);
    $this->set_public_assets(base_url());

    $this->load->library(array('Openslug', 'Openvisitor'));

    $this->controller = new \Pimple\Container();

    $this->controller['BasepRequest'] = $this->controller->factory(function($c) {
      return (new \Jasny\HttpMessage\ServerRequest())->withGlobalEnvironment();
    });
    $this->controller['BaseResponse'] = $this->controller->factory(function($c) {
      return (new \Jasny\HttpMessage\Response())->withGlobalEnvironment();
    });

    // needed for request->withServerParams(['REQUEST_METHOD' => 'GET' .. etc])->withQueryParams(['page' => 1 .. etc])
    $this->controller['BasepRequestEnv'] = $this->controller->factory(function($c) {
      return (new \Jasny\HttpMessage\ServerRequest())->withGlobalEnvironment(true);
    });

    $this->controller['BaseResponseEnv'] = $this->controller->factory(function($c) {
      return (new \Jasny\HttpMessage\Response())->withGlobalEnvironment(true);
    });
  }

  protected function set_public_assets($path)
  {
    $path .= 'assets'.DIRECTORY_SEPARATOR;
    $this->smarties->setup(array(
      'assets_css'    =>  $this->config->default_cfg(ASSETS_CSSPATH, $path.'css'.DIRECTORY_SEPARATOR),
      'assets_font'   =>  $this->config->default_cfg(ASSETS_FONTPATH, $path.'webfonts'.DIRECTORY_SEPARATOR),
      'assets_editor' =>  $this->config->default_cfg(ASSETS_EDITORPATH, $path.'editor'.DIRECTORY_SEPARATOR),
      'assets_js'     =>  $this->config->default_cfg(ASSETS_JSPATH, $path.'js'.DIRECTORY_SEPARATOR),
      'assets_img'    =>  $this->config->default_cfg(ASSETS_IMGPATH, $path.'images'.DIRECTORY_SEPARATOR),
      'asset_video'   =>  $this->config->default_cfg(ASSETS_VIDEOPATH, $path.'video'.DIRECTORY_SEPARATOR),
      'asset_favicon' =>  $this->config->default_cfg(ASSETS_FAVICONS, $path.'favicons'.DIRECTORY_SEPARATOR),
      'assets_upload' =>   $this->config->default_cfg(ASSETS_UPLOADPATH, $path.'uploads'.DIRECTORY_SEPARATOR),
    ));
  }

  protected function set_private_assets($path)
  {
    $path .= 'assets'.DIRECTORY_SEPARATOR;
    $this->smarties->setup(array(
      'assets_profile'  =>  $this->config->default_cfg(ASSETS_PROFILEPATH, $path.'profiles'.DIRECTORY_SEPARATOR),
    ));
  }
}

class Frontend_Controller extends MY_Controller
{
  public function __construct()
  {
      parent::__construct();
      //use default themes and forms
      $themes = $this->config->default_cfg(THEMES, 'defaults');

      $this->smarties->template_dir($this->config->default_cfg(THEMES_DIR, VIEWPATH).$themes.DIRECTORY_SEPARATOR);
  }
}

class Dashboard_Controller extends MY_Controller
{
  public function __construct()
  {
      parent::__construct();
      $this->smarties->template_dir($this->config->default_cfg(THEMES_DIR, VIEWPATH).'admin'.DIRECTORY_SEPARATOR);

      $this->set_private_assets(APPPATH);

      // make sure that token is exists
  }
}

class API_Controller extends MY_Controller
{
  protected $request;
  protected $response;

  public function __construct()
  {
    parent::__construct();

    // only shown filepath
    $this->set_private_assets(APPPATH);
    $this->request = $this->controller['HttpRequest'];
    $this->response = $this->controller['HttpResponse'];
  }

  // working with @users_model & $this->security
  protected function getToken()
  {
    if ()
  }

  protected function checkToken()
  // protected function checkBody($index = null)
  // protected function checkHeader($index = null)
  // protected function checkRequest($input, $rules)
  // protected function showResponse($data, $httpCode)

  public function pretty_json($data = array())
  {
    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  }
}
