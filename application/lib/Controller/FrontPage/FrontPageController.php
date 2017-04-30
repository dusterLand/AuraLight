<?php

namespace AuraLight\Controller\FrontPage;

use AuraLight\Common\Utility\AL_Log;
use AuraLight\Common\Utility\AL_Utility;
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
	public function __construct() {
		$this->log_frontpage = new AL_Log( 'FrontPage' );
		global $smarty;
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
	}
	/**
	 * Process user login.
	 */
	public function UserLogin() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called');
		if( isset( $_REQUEST['username']) && isset( $_REQUEST['password'])) {
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
		} else {
			exit( 'Bad request, handle this.' );
		}
		$this->log_frontpage->trace( $username, __FUNCTION__ . '$username' );
		$this->log_frontpage->trace( $password, __FUNCTION__ . '$password' );
//		TODO: You're here, Jason
		$this->DisplayPage(); // temp until you get more done
//		exit( "We made it here!" );
//		$user = new AL_Player;
//		$this=>active_login = AL_PlayerManager::Authenticate( $username, $password, $user );
//		$this->active_login = true;
	}
	/**
	 * Assign needed values.
	 */
	private function AssignValues() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called');
		global $smarty;
		$playerManager = new AL_PlayerManager();
		$player = $playerManager->displayManager(); 
		$javascript = array(
			'/javascript/jquery/jquery-3.2.1.js',
			'/javascript/auralight.js',
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
		$this->log_frontpage->trace( $player->get_attributes(), __FUNCTION__ . ' $player->get_attributes()');
		foreach( $player->get_attributes() as $at ){
			// exit(print_r($at,true));
			$accts[] = $at->account_name();
			
		}
		//exit(print_r($atts,true));
		//var_dump ($atts);
		//foreach($atts as $val) {
			//$atts['accounts'] = $val;
			//var_dump($val);
		//}
//		$smarty->assign( 'active_login', $this->active_login );
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
		$smarty->assign( 'tool_fullname', AL_Utility::TOOL_FULLNAME );
	}
	/**
	 * Render the page.
	 */
	public function DisplayPage() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called');
		global $smarty;
		$this->AssignValues( $smarty );
		$smarty->display( $smarty->template_dir[0] . 'index.smarty' );
	}
}
