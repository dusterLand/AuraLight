<?php

// Call Smarty connection script
//require_once('../../smarty-dusterland.php');
require_once('C:/Users/Jason/Documents/Programs/PHP/AuraLight/Controller/smarty-dusterland.php');
define( DOC_ROOT, 'C:/Users/Jason/Documents/Programs/PHP/AuraLight/' );
/**
 * Controller that will handle the application front page.
 */
class FrontPageController {
	/**
	 * Constructor function.
	 */
	public function __construct() {
		$smarty = new Smarty;
		$smarty->compile_check = true;
		$smarty->debugging = true;
		$smarty->template_dir = DOC_ROOT . 'View/FrontPage/Template/';
		$smarty->compile_dir =  DOC_ROOT . 'View/FrontPage/Template_c/';
		$smarty->config_dir = DOC_ROOT . 'View/FrontPage/Config/';
	}
	/**
	 * Theoretically this will be called to actually render the page.
	 */
	public function Display() {
		$smarty->display( $smarty->template_dir . 'index.smarty' );
	}
}