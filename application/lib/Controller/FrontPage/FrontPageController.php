<?php

namespace AuraLight\Controller\FrontPage;

use AuraLight\Common\Utility\AL_Log;
use AuraLight\Model\Manager\AL_GameManager;

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
		$gameManager = new AL_GameManager();
		$player=$gameManager->displayManager(); 
		$javascript = array(
			'../../javascript/jquery/jquery-3.1.1.js',
			'../../javascript/auralight.js',
		);
		$stylesheets = array(
			'/CSS/index.css',
			'/CSS/al_menu.css',
		);
		$this->result = pg_query("SELECT id, race_name, race_reputation_name FROM al_race");
		$data = array('races');
		while($row = pg_fetch_assoc($this->result)) {
			$data['races'][] = $row;
		}
		$smarty->assign( 'playername', $player->username());
		$smarty->assign( 'playeremail', $player->email());
		$smarty->assign( 'player_last_name', $player->name_last());
		$smarty->assign( 'player_middle_name', $player->name_middle());
		$smarty->assign( 'player_first_name', $player->name_first());
		$smarty->assign( 'races', $data['races']);
		$smarty->assign( 'stylesheets', $stylesheets );
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
