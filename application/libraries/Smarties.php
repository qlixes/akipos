<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

define('THEMES', 1);
define('THEMES_DIR', 2);
define('COMPILE_DIR', 3);
define('ENV_MODE', 4);
define('ENV_UNASSIGNED', 6);
define('ENV_ERROR_MODE', 7);
define('CACHE_DIR', 54);

class Smarties {
	private $CI;
  private $data = array();
  private $smarty;

  public function __construct()
  {
    log_message('debug', 'Smarty: library initialized');
    $this->CI =& get_instance();

    try {
      $this->smarty = new Smarty();

      $this->smarty->error_reporting = $this->CI->config->default_cfg(ENV_ERROR_MODE, E_ALL & ~E_NOTICE);

      $this->smarty->setCompileDir($this->CI->config->default_cfg(COMPILE_DIR, APPPATH.'compiled'.DIRECTORY_SEPARATOR))
										->setCacheDir($this->CI->config->default_cfg(CACHE_DIR, APPPATH.'cache'.DIRECTORY_SEPARATOR));

			if ($this->CI->config->default_cfg(ENV_MODE, 'development') == 'production') {
				$this->smarty->force_compile = 0;
				$this->smarty->debugging = false;
			} else {
				$this->smarty->force_compile = 1;
				$this->smarty->debugging = true;
				// $this->CI->output->enable_profiler = true;
			};
    } catch (Exception $e) {
      show_error(htmlspecialchars_decode($e->getMessage()), 500, 'Smarty Exception');
    };
  }

	public function template_dir($dir)
	{
		$this->smarty->setTemplateDir($dir);
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
			$this->smarty->assign('this', $this->CI);
      //merge with $this->data
      foreach($this->data as $key => $value) {
        $this->smarty->assign($key, $value);
      };
      $templates = $this->smarty->fetch($template);
      $this->error_unassigned = $this->CI->config->default_cfg(ENV_UNASSIGNED, 'false');
      if ($return === false) {
        $this->CI->output->append_output($templates);
        return true;
      };
    } catch (Exception $e) {
      show_error(htmlspecialchars_decode($e->getMessage()), 500, 'Smarty Exception');
    };
    unset($this->data);
    return $this->CI->output->_display();
  }
	/**
	 * cache mode each page
	 */
	public function disable_cache()
	{
		$this->smarty->caching = 0;
	}

	public function enable_cache()
	{
		$this->smarty->caching = 1;
	}
}
