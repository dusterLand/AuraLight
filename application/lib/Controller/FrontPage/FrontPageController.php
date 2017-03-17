<?php

// include('log4php/Logger.php');

namespace AuraLight\Controller\FrontPage;

use AuraLight\Common\Utility\AL_Log;

class FrontPageController {

	private $name1;
	private $name2;
	private $conn;
	private $sql;
	private $result;
	private $log_frontpage;
	private $testlog;
	
	
		
	/**
	 * Constructor function.
	 */
	public function __construct( $config, $smarty, $conn ) {
		$this->conn = $conn;
		$this->name1 = $config['app']['name1'];
		$this->name2 = $config['app']['name2'];
		$this->testlog = new AL_Log;
//		Logger::configure( LOG_CONFIG . '/frontpage.xml');
//		$this->log_frontpage = Logger::getLogger(__CLASS__);
//		$this->log_frontpage->configure( LOG_CONFIG . '/frontpage.xml');
//		Logger::configure(dirname(__FILE__) .'/../share/config/log4php/defaultLog4PHP.xml');
//		$this->log_frontpage = $config['app']['log_frontpage'];
//		$x = $config['log_config']['log_frontpage'];
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
	}
	/**
	 * Assign needed values.
	 */
	private function AssignValues( $smarty ) {
//		$this->log_frontpage->trace('called');
		$javascript = array(
			'../../javascript/jquery/jquery-3.1.1.js',
			'../../javascript/auralight.js',
		);
		//$smarty;
		$smarty->assign( 'name1', $this->name1 );
		$smarty->assign( 'name2', $this->name2 );
		$smarty->assign( 'stylesheet', '/CSS/index.css' );
		$smarty->assign( 'javascript', $javascript );
		$smarty->assign( 'log', $this->testlog->test1());
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage($smarty) {
		
		$this->sql = "SELECT id, race_name, race_reputation_name  FROM al_race";
		$this->result = pg_exec($this->sql);

		for ($lt = 0; $lt <pg_numrows($this->result); $lt++) {
			$id = pg_result($this->result, $lt, 0);
			$this->name1 = pg_result($this->result, $lt, 1);
			$this->name2 = pg_result($this->result, $lt, 2);
		}
		
		
//		$this->log_frontpage->trace('called');
		//global $smarty;
		$this->AssignValues( $smarty );
		$smarty->display( $smarty->template_dir[0] . 'index.smarty' );
	}
}
