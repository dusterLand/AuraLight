<?php

namespace AuraLight\FrontPage;

class FrontPageController {

	private $name1;
	private $name2;
	/**
	 * Constructor function.
	 */
	public function __construct($config,$smarty,$log_default) {
		$this->name1 = $config['app']['name1'];
		$this->name2 = $config['app']['name2'];
		$log_default = $config['app']['log_default'];
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
	}
	/**
	 * Assign needed values.
	 */
	private function AssignValues($smarty,$log_default) {
		$log_default->trace('called');
		$javascript = array(
			'../../javascript/jquery/jquery-3.1.1.js',
			'../../javascript/auralight.js',
		);
		//$smarty;
		$smarty->assign( 'name1', $this->name1 );
		$smarty->assign( 'name2', $this->name2 );
		$smarty->assign( 'stylesheet', '/CSS/index.css' );
		$smarty->assign( 'javascript', $javascript );
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage($smarty,$log_default) {
		$log_default->trace('called');
		//global $smarty;
		$this->AssignValues($smarty,$log_default);
		$smarty->display( $smarty->template_dir[0] . 'index.smarty' );
	}
}
