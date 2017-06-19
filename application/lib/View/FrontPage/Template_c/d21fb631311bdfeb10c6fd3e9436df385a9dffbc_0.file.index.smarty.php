<?php
/* Smarty version 3.1.31, created on 2017-06-18 09:05:40
  from "C:\development_work\repos\AuraLight\application\lib\View\FrontPage\Template\index.smarty" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59467aa49318f7_49226525',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd21fb631311bdfeb10c6fd3e9436df385a9dffbc' => 
    array (
      0 => 'C:\\development_work\\repos\\AuraLight\\application\\lib\\View\\FrontPage\\Template\\index.smarty',
      1 => 1497790640,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../../al_menu.smarty' => 1,
  ),
),false)) {
function content_59467aa49318f7_49226525 (Smarty_Internal_Template $_smarty_tpl) {
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
		<?php $_smarty_tpl->_subTemplateRender('file:../../al_menu.smarty', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<?php if ($_smarty_tpl->tpl_vars['user_login']->value) {?>
			<p><?php echo $_smarty_tpl->tpl_vars['playername']->value;?>
 with email: <?php echo $_smarty_tpl->tpl_vars['playeremail']->value;?>
 and full name: <?php echo $_smarty_tpl->tpl_vars['player_first_name']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['player_middle_name']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['player_last_name']->value;?>
 with password <?php echo $_smarty_tpl->tpl_vars['player_password']->value;?>
 with the following accounts: </p>
		<?php }?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['accounts']->value, 'attrs');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['attrs']->value) {
?>
			<p>Account: <?php echo $_smarty_tpl->tpl_vars['attrs']->value;?>
</p>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['races']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
			<p><?php echo $_smarty_tpl->tpl_vars['row']->value['race_name'];?>
 is this <?php echo $_smarty_tpl->tpl_vars['row']->value['race_reputation_name'];?>
</p>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		<div id="home_bottom">
			<div id="button_test_jquery">Test JQuery</div>
		</div>
	</body>
</html>
<?php }
}
