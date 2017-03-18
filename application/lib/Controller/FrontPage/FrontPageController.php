<?php

namespace AuraLight\Controller\FrontPage;

use AuraLight\Common\Utility\AL_Log;

class FrontPageController {

	private $race;
	private $reputation;
	private $conn;
	private $sql;
	private $result;
	private $log_frontpage;
	private $races;
	/**
	 * Constructor function.
	 */
	public function __construct( $smarty ) {
		$this->log_frontpage = new AL_Log( 'FrontPage' );
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
	}
	/**
	 * Assign needed values.
	 */
	private function AssignValues( $smarty ) {
		$this->log_frontpage->trace('called');
		$javascript = array(
			'../../javascript/jquery/jquery-3.1.1.js',
			'../../javascript/auralight.js',
		);
		$this->result = pg_query("SELECT id, race_name, race_reputation_name FROM al_race");
		$data = array('races');
		while($row = pg_fetch_assoc($this->result)) {
			$data['races'][] = $row;
		}
		$smarty->assign( 'races', $data['races']);
		$smarty->assign( 'stylesheet', '/CSS/index.css' );
		$smarty->assign( 'javascript', $javascript );
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage( $smarty ) {
		$this->log_frontpage->trace('called');
		$this->AssignValues( $smarty );
		$smarty->display( $smarty->template_dir[0] . 'index.smarty' );
	}
}
