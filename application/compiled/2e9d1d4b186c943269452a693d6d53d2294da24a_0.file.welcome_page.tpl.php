<?php
/* Smarty version 3.1.32, created on 2018-06-10 19:18:08
  from '/opt/lampp/htdocs/news2/application/views/defaults/welcome_page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b1d5d50645ef2_86704981',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e9d1d4b186c943269452a693d6d53d2294da24a' => 
    array (
      0 => '/opt/lampp/htdocs/news2/application/views/defaults/welcome_page.tpl',
      1 => 1528109220,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:[parts]header.tpl' => 1,
    'file:[parts]footer.tpl' => 1,
  ),
),false)) {
function content_5b1d5d50645ef2_86704981 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:[parts]header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<nav class="pagination is-rounded" role="navigation" aria-label="pagination">
  <ul class="pagination-list">
    <li><a class="pagination-previous" aria-label="Prev page">Previous</a></li>
    <li><a class="pagination-link" aria-label="Goto page 1">1</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page 45">45</a></li>
    <li><a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a></li>
    <li><a class="pagination-link" aria-label="Goto page 47">47</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page 86">86</a></li>
    <li><a class="pagination-next" aria-label="Next page">Next</a></li>
  </ul>
</nav>

<nav class="pagination is-rounded" role="navigation" aria-label="pagination">
  <a class="pagination-previous">Previous</a>
  <a class="pagination-next">Next page</a>
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1">1</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page 45">45</a></li>
    <li><a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a></li>
    <li><a class="pagination-link" aria-label="Goto page 47">47</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page 86">86</a></li>
  </ul>
</nav>

<?php $_smarty_tpl->_subTemplateRender('file:[parts]footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
