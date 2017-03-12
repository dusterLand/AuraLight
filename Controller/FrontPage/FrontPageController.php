<?php

// Smarty setup; NONE of this is tested yet
require_once('smarty-winxp.php');
define( SMARTY_DIR, 'D:\\Users\\Jason\\Documents\\Programs\\PHP\\AuraLight\\smarty\\' );
require_once( SMARTY_DIR.'Smarty.class.php' );
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
		$smarty->template_dir = MY_DIR;
	}
	/**
	 * Theoretically this will be called to actually render the page.
	 */
	public function Display() {
	}
}