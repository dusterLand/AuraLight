<?php
/* Smarty version 3.1.30, created on 2017-03-13 23:39:37
  from "C:\development_work\repos\AuraLight\application\View\FrontPage\Template\index.smarty" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c72db95b7698_43836682',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f9d838cc5ae8e5b52589e9ea6f46eb620fa3f961' => 
    array (
      0 => 'C:\\development_work\\repos\\AuraLight\\application\\View\\FrontPage\\Template\\index.smarty',
      1 => 1489447551,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c72db95b7698_43836682 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>AuraLight Smarty Testbed</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
" />
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['javascript']->value, 'jsfile');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['jsfile']->value) {
?>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jsfile']->value;?>
"><?php echo '</script'; ?>
>
		<?php
}
} else {
?>

		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</head>
	<body>
		<p>Testing Smarty templating service.</p>
		<p><?php echo $_smarty_tpl->tpl_vars['name1']->value;?>
 is not <?php echo $_smarty_tpl->tpl_vars['name2']->value;?>
</p>
	</body>
</html><?php }
}
