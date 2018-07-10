<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Config extends CI_Config
{
  private $table;

  private $configs = array(
    1 =>  'smarty.template.themes',
    2 =>  'smarty.template.themesDir',
    3 =>  'smarty.template.compileDir',
    4 =>  'smarty.env.mode',
    5 =>  'smarty.assets.editorPath',
    6 =>  'smarty.env.unassigned',
    7 =>  'smarty.env.errorMode',
    8 =>  'smarty.assets.jsPath',
    9 =>  'smarty.assets.cssPath',
    10  =>  'smarty.assets.imgPath',
    11  =>  'smarty.assets.uploadPath',
    12  =>  'button.span.facebook',
    13  =>  'button.span.twitter',
    14  =>  'button.span.gplus',
    15  =>  'button.span.username',
    16  =>  'button.span.password',
    17  =>  'button.span.email',
    18  =>  'button.span.signin',
    19  =>  'button.span.signout',
    20  =>  'button.span.add',
    21  =>  'button.span.edit',
    22  =>  'button.span.remove',
    23  =>  'button.span.active',
    24  =>  'button.span.inactive',
    25  =>  'apps.profiler.enable',
    26  =>  'api.error.authenticate',
    44  =>  'smarty.page.perPage',
    45  =>  'smarty.assets.fontPath',
    46  =>  'apps.auth.issuer',
    47  =>  'apps.auth.audience',
    48  =>  '',
    49  =>  '',
    50  =>  '',
    51  =>  '',
    52  =>  '',
    53  =>  'apps.assets.videoPath',
    54  =>  'smarty.template.cacheDir',
    55  =>  'smarty.assets.favicon',
    56  =>  'smarty.assets.profilePath',
    57  =>  'smarty.page.usePageNumbers',
    58  =>  'smarty.page.pageQryString',
    59  =>  'smarty.page.enableQryString',
    60  =>  'smarty.page.reuseQryString',
    61  =>  'smarty.page.displayPages',
    62  =>  'smarty.page.serialNumber',
    63  =>  'apps.data.dateFormat',
    64  =>  'apps.data.currencyFormat',
    65  =>  'apps.data.datetimeFormat'
  );

  public function __construct()
  {
    parent::__construct();
    $this->table = 'configs';
  }

  // public function default_cfg($id, $default)
  // {
  //   if(is_null($this->config_model->cfg_read($id))) {
  //     $this->config_model->cfg_update($default);
  //   };
  //   return $this->config_model->cfg_read($id);
  // }

  //get data from db, if empty will fill with default
  public function default_cfg($id, $default)
  {
    $CI =& get_instance();
    $CI->db->where(array('id' =>  $id));
    $result = $CI->db->get($this->table);
    // var_dump($row->cfg_value);
    if (empty($result->row()->cfg_value)) {
      $data = array(
        'id'  =>  $id,
        'cfg_value' =>  $default,
        'cfg_code'  =>  $this->configs[$id]
      );
      $CI->db->where(array('id' =>  $id));
      $CI->db->replace($this->table, $data);
    };
    return $result->row_array()['cfg_value'];
  }

  // public function reset_cfg($id, $default)
  // {
  //   $CI->db->set('cfg_value', '');
  //   // $CI->db->where(array('id' =>  $id));
  //   $CI->db->update($this->table);
  // }
}
