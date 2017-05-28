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
	private $active_login;
	private $player_manager;
	
	/**
	 * Constructor function.
	 */
	public function __construct() {
		$this->log_frontpage = new AL_Log( 'FrontPage' );
		global $smarty;
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
		if( isset( $_SESSION['id'] )) {
			$this->active_login = $_SESSION['id'];
		}
	}
	/**
	 * Assign needed values.
	 */
	private function AssignValues() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called');
		global $smarty;
		$player;
		if( $this->active_login ) {
			$player = $this->playerManager()->PlayerBySession( $this->active_login );
		}
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
		if( $this->active_login ) {
			$this->log_frontpage->trace( $player->get_attributes(), __FUNCTION__ . ' $player->get_attributes()');
		}
		if( isset( $player )) {
			foreach( $player->get_attributes() as $at ){
				// exit(print_r($at,true));
				$accts[] = $at->account_name();
			}
		}
		//exit(print_r($atts,true));
		//var_dump ($atts);
		//foreach($atts as $val) {
			//$atts['accounts'] = $val;
			//var_dump($val);
		//}
		$smarty->assign( 'user_login', ($this->active_login ? true : false) );
		$this->log_frontpage->trace( ($this->active_login ? 'true' : 'false' ), __FUNCTION__ . ' $this->active_login');
		if( $this->active_login ) {
//			$smarty->assign( 'user_login', true );
			$smarty->assign( 'login_username', $player->username() );
		}
		$smarty->assign( 'active_login', $this->active_login );
		if( $this->active_login ) {
			$smarty->assign( 'playername', $player->username());
			$smarty->assign( 'playeremail', $player->email());
			$smarty->assign( 'player_last_name', $player->name_last());
			$smarty->assign( 'player_middle_name', $player->name_middle());
			$smarty->assign( 'player_first_name', $player->name_first());
			$smarty->assign( 'player_password', $player->password());
		}
		$smarty->assign( 'accounts', $accts);
		$smarty->assign( 'races', $data['races']);
		$smarty->assign( 'stylesheets', $stylesheets );
		$smarty->assign( 'javascript', $javascript );
		$smarty->assign( 'tool_fullname', AL_Utility::TOOL_FULLNAME );
	}
	/**
	 * Set (if needed) and return player manager.
	 */
	private function playerManager() {
		$this->log_frontpage->trace( __FUNCTION__ . 'called' );
		if( !(isset( $this->player_manager )) ) {
			$this->player_manager = new AL_PlayerManager();
		}
		return $this->player_manager;
	}
	/**
	 * Process user login.
	 */
	public function UserLogin() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called' );
		if( isset( $_REQUEST['username']) && isset( $_REQUEST['userpass'])) {
			$username = $_REQUEST['username'];
			$password = $_REQUEST['userpass'];
		} else {
			exit( 'Bad request, handle this.' );
		}
		$json_response = array(
			'data' => '',
			'message' => '',
			'success' => 0,
		);
		$this->active_login = $this->playerManager()->Authenticate( $username, $password );
		if( $this->active_login !== null ) {
			$_SESSION['id'] = $this->active_login;
			$json_response['success'] = 1;
		}
		$this->log_frontpage->trace( $json_response, __FUNCTION__ . ' $json_response');
		header('Content-Type: application/json');
		echo( json_encode( $json_response ));
	}
	/**
	 * Process user logout.
	 */
	public function UserLogout() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called' );
		session_unset();
		$this->active_login = false;
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
