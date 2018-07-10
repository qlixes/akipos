<?php
/* Smarty version 3.1.32, created on 2018-06-01 02:56:46
  from '/opt/lampp/htdocs/news2/application/views/defaults/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b1099ce739574_61406879',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1f41d7ed21ee622cb822d15a430ecab29f0fa223' => 
    array (
      0 => '/opt/lampp/htdocs/news2/application/views/defaults/footer.tpl',
      1 => 1525570036,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b1099ce739574_61406879 (Smarty_Internal_Template $_smarty_tpl) {
?>	<?php
$__section_js_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['assets_js']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_js_1_total = $__section_js_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_js'] = new Smarty_Variable(array());
if ($__section_js_1_total !== 0) {
for ($__section_js_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_js']->value['index'] = 0; $__section_js_1_iteration <= $__section_js_1_total; $__section_js_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_js']->value['index']++){
?>
		<?php echo '<script'; ?>
 async="" defer="" src="<?php echo $_smarty_tpl->tpl_vars['assets_path']->value;?>
js/<?php echo $_smarty_tpl->tpl_vars['assets_js']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_js']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_js']->value['index'] : null)];?>
"><?php echo '</script'; ?>
>
	<?php
}
}
?>
  </body>
</html><?php }
}
