<?php

// Call Smarty connection script
//require_once('../../smarty-dusterland.php');
define( 'DOC_ROOT', getenv('DOCUMENT_ROOT').'/');
require_once(DOC_ROOT .'/Controller/smarty-dusterland.php');
/**
 * Controller that will handle the application front page.
 */
class FrontPageController {
	
	private $smarty;
	/**
	 * Constructor function.
	 */
	public function __construct() {
		$this->smarty = new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->debugging = true;
		$this->smarty->template_dir = DOC_ROOT . 'View/FrontPage/Template/';
		$this->smarty->compile_dir = DOC_ROOT . 'View/FrontPage/Template_c/';
		$this->smarty->config_dir = DOC_ROOT . 'View/FrontPage/Config/';
	}
	/**
	 * Theoretically this will be called to actually render the page.
	 */
	public function DisplayPage() {
//		die( print_r( $this->smarty->template_dir, false ));
		$this->smarty->display( $this->smarty->template_dir[0] . 'index.smarty' );
	}
}
