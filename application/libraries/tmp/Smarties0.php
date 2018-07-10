<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

define('THEMES', 1);
define('THEMES_DIR', 2);
define('COMPILE_DIR', 3);
define('ENV_MODE', 4);
define('ENV_CACHE', 5);
define('ENV_UNASSIGNED', 6);
define('ENV_ERROR_MODE', 7);
define('ASSETS_JSPATH', 8);
define('ASSETS_CSSPATH', 9);
define('ASSETS_IMGPATH', 10);
define('ASSETS_UPLOADPATH', 11);
define('ASSETS_VIDEOPATH', 53);
define('CACHE_DIR', 54);

class Smarties {
	private $CI;
  private $data = array();
  private $_smarty;

  public function __construct()
  {
    log_message('debug', 'Smarty: library initialized');
    $this->CI =& get_instance();

    try {
      $this->_smarty = new Smarty();

      $this->_smarty->error_reporting = $this->CI->config->default_cfg(ENV_ERROR_MODE, E_ALL & ~E_NOTICE);

      // $this->_smarty->setTemplateDir($this->_config['templates_dir'])
      //               ->setCompileDir($this->_config['compile_dir'])
      //               ->setCacheDir($this->_config['cache_dir']);


			if ($this->_config['environment']['status'] == 'production') {
				$this->_smarty->force_compile = 0;
				$this->_smarty->debugging = false;
			} else {
				$this->_smarty->force_compile = 1;
				$this->_smarty->debugging = true;
			};
    } catch (Exception $e) {
      show_error(htmlspecialchars_decode($e->getMessage()), 500, 'Smarty Exception');
    };
  }

  public function setup($data = array(), $return = FALSE)
  {
    $this->data = array_merge($data, $this->data);
  }

  public function view($template, $return = FALSE)
	{
    $template .= '.tpl';
    try {
			//getting CI object for each tpl
			$this->_smarty->assign('this', $this->CI);
      //merge with $this->data
      foreach($this->data as $key => $value) {
        $this->_smarty->assign($key, $value);
      };
      $templates = $this->_smarty->fetch($template);
      $this->error_unassigned = $this->_config['environment']['unassigned'];
      if ($return === false) {
        $this->CI->output->append_output($templates);
        return true;
      };
    } catch (Exception $e) {
      show_error(htmlspecialchars_decode($e->getMessage()), 500, 'Smarty Exception');
    }
    unset($this->data);
    return $this->CI->output->_display();
  }
	/**
	 * cache mode each page
	 */
	public function disable_cache()
	{
		$this->_smarty->caching = 0;
	}

	public function enable_cache()
	{
		$this->_smarty->caching = 1;
	}
}
