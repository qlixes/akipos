<?php
/* Smarty version 3.1.32, created on 2018-06-01 02:56:46
  from '/opt/lampp/htdocs/news2/application/views/defaults/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b1099ce6bdbd9_15564466',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4a223bbeec102b8bca652ef0e8f89ddcfca651ad' => 
    array (
      0 => '/opt/lampp/htdocs/news2/application/views/defaults/header.tpl',
      1 => 1525570036,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b1099ce6bdbd9_15564466 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html class="has-navbar-fixed-top">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <?php
$__section_css_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['assets_css']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_css_0_total = $__section_css_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_css'] = new Smarty_Variable(array());
if ($__section_css_0_total !== 0) {
for ($__section_css_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_css']->value['index'] = 0; $__section_css_0_iteration <= $__section_css_0_total; $__section_css_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_css']->value['index']++){
?>
      <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets_path']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['assets_css']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_css']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_css']->value['index'] : null)];?>
">
    <?php
}
}
?>
  </head>
  <body><?php }
}
