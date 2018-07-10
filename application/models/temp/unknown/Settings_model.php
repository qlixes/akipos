<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

/**
* Model client should return itself result
**/

class Settings_model extends MY_Model implements IModel
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'settings';
	}

	private function set_labels($label, $prefix = null)
	{
		$this->set_data(array(
			'labels'	=> "$prefix.$label"
		));
	}

	// public function show_admin()
	// {
	// 	return $this->show('labels, desc_settings, admin_settings, is_active');
	// }

	// public function show_public()
	// {
	// 	return $this->show('labels, desc_settings, public_settings, is_active');
	// }
}