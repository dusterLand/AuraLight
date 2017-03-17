<?php

// include('log4php/Logger.php');

namespace AuraLight\Controller\TestPage;

use AuraLight\Common\Utility\AL_Log;

class TestPageController {

	/**
	 * Constructor function.
	 */
	public function __construct( $config, $smarty ) {
		$smarty->template_dir =  '../lib/View/TestPage/Template/';
		$smarty->compile_dir = '../lib/View/TestPage/Template_c/';
		$smarty->config_dir = '../lib/View/TestPage/Config/';
	}
	/**
	 * Assign needed values.
	 */
	private function AssignValues( $smarty ) {
		$javascript = array(
			'../../javascript/jquery/jquery-3.1.1.js',
		);
		//$smarty;
		$smarty->assign( 'stylesheet', '/CSS/testpage.css' );
		$smarty->assign( 'javascript', $javascript );
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage( $smarty ) {
		$this->AssignValues( $smarty );
		$smarty->display( $smarty->template_dir[0] . 'testpage.smarty' );
	}
}
