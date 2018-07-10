<?php
/* Smarty version 3.1.32, created on 2018-06-05 08:29:15
  from '/opt/lampp/htdocs/news2/application/views/api/welcome_page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b162dbbb5a036_14398116',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8fc279f8063302f3f1251d79c71fabf2ff93902' => 
    array (
      0 => '/opt/lampp/htdocs/news2/application/views/api/welcome_page.tpl',
      1 => 1528125615,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b162dbbb5a036_14398116 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets_css']->value;?>
bulma.min.css">
    <?php echo '<script'; ?>
 defer src="<?php echo $_smarty_tpl->tpl_vars['assets_js']->value;?>
all.js"><?php echo '</script'; ?>
>
  </head>
  <body>
  <section class="section">
    <div class="container">
      <h1 class="title">
        Hello World
      </h1>
      <p class="subtitle">
        API Restfull Service with <strong>CodeIgniter</strong>!
      </p>
    </div>
  </section>
  </body>
</html>
<?php }
}
