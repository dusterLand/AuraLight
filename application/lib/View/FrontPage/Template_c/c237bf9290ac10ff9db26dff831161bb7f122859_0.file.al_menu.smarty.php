<?php
/* Smarty version 3.1.31, created on 2017-06-18 08:38:56
  from "C:\development_work\repos\AuraLight\application\lib\View\al_menu.smarty" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59467460ddde06_65665705',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c237bf9290ac10ff9db26dff831161bb7f122859' => 
    array (
      0 => 'C:\\development_work\\repos\\AuraLight\\application\\lib\\View\\al_menu.smarty',
      1 => 1497789516,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59467460ddde06_65665705 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="auralight_menu">
	<div id="al_menu_title_container">
		<div id="al_menu_title"><?php echo $_smarty_tpl->tpl_vars['tool_fullname']->value;?>
</div>
		<?php if ($_smarty_tpl->tpl_vars['user_login']->value) {?>
			<div id="login_information">
				Logged in as: <b><?php echo (($tmp = @$_smarty_tpl->tpl_vars['login_username']->value)===null||$tmp==='' ? null : $tmp);?>
</b>
			</div>
		<?php } else { ?>
			<div id="login_fields">
				<input id="username" type="text" name="username" rows="1" form="loginForm" maxlength="12" placeholder="Username"></input><br />
				<input id="userpass" type="password" name="password" rows="1" form="loginForm" maxlength="12" placeholder="Password"></input>
			</div>
		<?php }?>
		<div class="clear"></div>
	</div>
	<div class="al_menu_item" name="front_page">Front Page</div>
	<div id="login_button_container">
	<?php if (!$_smarty_tpl->tpl_vars['user_login']->value) {?>
		<button id="submit_login" class="login_button">Login</button>
		<button id="submit_registration" class="registration_button">Registration</button>
	<?php } else { ?>
		<button id="submit_logout" class="logout_button">Logout</button>
	<?php }?>
	</div>

	<div class="clear"></div>
</div>
<?php }
}
