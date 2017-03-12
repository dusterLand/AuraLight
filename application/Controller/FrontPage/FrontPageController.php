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
	 * Assign values for variables the page will use.
	 */
	private function AssignValues() {
		$name1 = 'Tom';
		$name2 = 'Gus';
		$javascript = array(
			'../../javascript/jquery-3.1.1.js',
			'../../javascript/auralight.js',
		);
		$this->smarty->assign( 'name1', $name1 );
		$this->smarty->assign( 'name2', $name2 );
		$this->smarty->assign( 'stylesheet', '../../View/FrontPage/CSS/index.css' );
		$this->smarty->assign( 'javascript', $javascript );
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage() {
		$this->AssignValues();
		$this->smarty->display( $this->smarty->template_dir[0] . 'index.smarty' );
	}
}
