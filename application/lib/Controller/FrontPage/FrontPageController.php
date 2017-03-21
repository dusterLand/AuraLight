<?php

namespace AuraLight\Controller\FrontPage;

use AuraLight\Common\Utility\AL_Log;
use AuraLight\Model\Manager\AL_PlayerManager;


class FrontPageController {

	private $race;
	private $reputation;
	private $conn;
	private $sql;
	private $result;
	private $log_frontpage;
	private $races;
	private $accounts;
	private $atts;
	
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
		$playerManager = new AL_PlayerManager();
		$player=$playerManager->displayManager(); 
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
		//$ad = $player->get_attributes();
		//var_dump ($ad);
		//$atts = array($player->get_attributes());
		//$atts = $player->get_attributes();
		//exit(print_r(count($atts),true));
		$accts = array();
		foreach($player->get_attributes() as $at){
			//exit(print_r($at,true));
			$accts[]=$at->account_name();
			
		}
		//exit(print_r($atts,true));
		//var_dump ($atts);
		//foreach($atts as $val) {
			//$atts['accounts'] = $val;
			//var_dump($val);
		//}
		
		$smarty->assign( 'playername', $player->username());
		$smarty->assign( 'playeremail', $player->email());
		$smarty->assign( 'player_last_name', $player->name_last());
		$smarty->assign( 'player_middle_name', $player->name_middle());
		$smarty->assign( 'player_first_name', $player->name_first());
		$smarty->assign( 'player_password', $player->password());
		$smarty->assign( 'accounts', $accts);
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
