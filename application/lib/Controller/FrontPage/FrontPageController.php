<?php

// Define document root
define( 'DOC_ROOT', getenv('DOCUMENT_ROOT').'/' );
// Include logger
include( 'log4php/Logger.php' );
// Call Smarty connection script
require_once( DOC_ROOT .'Controller/smarty-dusterland.php' );
/**
 * Controller that will handle the application front page.
 */
class FrontPageController {
	
	private $smarty;
	private $log_frontpage;
	/**
	 * Constructor function.
	 */
	public function __construct() {
		// Configure logging
		Logger::configure( DOC_ROOT . '../config/log4php/frontpage.xml' );
		$this->log_frontpage = Logger::getLogger( 'FrontPage' );
		// Configure Smarty
		$this->smarty = new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->debugging = true;
		$this->smarty->template_dir = DOC_ROOT . '../View/FrontPage/Template/';
		$this->smarty->compile_dir = DOC_ROOT . '../View/FrontPage/Template_c/';
		$this->smarty->config_dir = DOC_ROOT . '../View/FrontPage/Config/';
	}
	/**
	 * Assign values for variables the page will use.
	 */
	private function AssignValues() {
		$this->log_frontpage->trace('called');
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
		$this->log_frontpage->trace('called');
		$this->AssignValues();
		$this->smarty->display( $this->smarty->template_dir[0] . 'index.smarty' );
	}
}
