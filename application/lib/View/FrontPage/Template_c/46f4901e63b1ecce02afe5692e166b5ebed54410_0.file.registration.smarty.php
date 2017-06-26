<?php
/* Smarty version 3.1.31, created on 2017-06-18 14:10:59
  from "C:\development_work\repos\AuraLight\application\lib\View\FrontPage\Template\registration.smarty" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5946c23394fc34_23919211',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46f4901e63b1ecce02afe5692e166b5ebed54410' => 
    array (
      0 => 'C:\\development_work\\repos\\AuraLight\\application\\lib\\View\\FrontPage\\Template\\registration.smarty',
      1 => 1497809449,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5946c23394fc34_23919211 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo $_smarty_tpl->tpl_vars['tool_fullname']->value;?>
 (DEVELOPMENT)</title>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stylesheets']->value, 'stylesheet');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['stylesheet']->value) {
?>
		<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
" />
		<?php
}
} else {
?>

		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['javascript']->value, 'jsfile');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['jsfile']->value) {
?>
		<?php echo '<script'; ?>
 language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jsfile']->value;?>
"><?php echo '</script'; ?>
>
		<?php
}
} else {
?>

		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	</head>
	<body>
		<div id="auralight_menu">
			<div id="al_menu_title_container">
				<div id="al_menu_title"><?php echo $_smarty_tpl->tpl_vars['tool_fullname']->value;?>
</div>	
				<div class="clear"></div>
			</div>
			<div class="al_menu_item" name="registration">Registration</div>
			<div id="registration_button_container">
	
			</div>

			<div class="clear"></div>
		</div>
	</body>
</html><?php }
}
