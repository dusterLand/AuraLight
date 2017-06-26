<?php
/* Smarty version 3.1.30, created on 2017-03-14 00:21:07
  from "C:\development_work\repos\AuraLight\View\FrontPage\Template\index.smarty" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c73773cba111_90557909',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8b32daa69e48fcb8e5fcec127cec408f994e84eb' => 
    array (
      0 => 'C:\\development_work\\repos\\AuraLight\\View\\FrontPage\\Template\\index.smarty',
      1 => 1489447551,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c73773cba111_90557909 (Smarty_Internal_Template $_smarty_tpl) {
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
