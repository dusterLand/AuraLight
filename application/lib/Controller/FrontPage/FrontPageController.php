<?php

namespace AuraLight\Controller\FrontPage;

use AuraLight\Common\Utility\AL_Log;
use AuraLight\Common\Utility\AL_Utility;
use AuraLight\Model\Manager\AL_PlayerManager;

class FrontPageController {
	private $accounts;
	private $active_login;
	private $atts;
	private $conn;
	private $log_frontpage;
	private $log_registration;
	private $player_manager;
	private $race;
	private $races;
	private $reputation;
	private $result;
	private $sql;
	/**
	 * Constructor function.
	 */
	public function __construct() {
		$this->log_frontpage = new AL_Log( 'FrontPage' );
		$this->log_registration = new AL_Log( 'Registration' );
		global $smarty;
		$smarty->template_dir =  '../lib/View/FrontPage/Template/';
		$smarty->compile_dir = '../lib/View/FrontPage/Template_c/';
		$smarty->config_dir = '../lib/View/FrontPage/Config/';
		// check & validate login
		if( isset( $_SESSION['id'] )) {
			$retrieved_session_id = $_SESSION['id'];
			$player_result = $this->playerManager()->PlayerBySession( $retrieved_session_id );
			$this->active_login = !$player_result ? false : $retrieved_session_id;
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
			'/javascript/registration.js',
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
			foreach( (array)$player->get_attributes() as $at ){
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
		$smarty->assign( 'page', 'index');
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
	 * user Profile
	 */
	 public function UserProfile() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called' );
		global $smarty;
		$this->AssignValues( $smarty );
		$smarty->template_dir =  '../lib/View/UserProfile/Template/';
		$smarty->compile_dir = '../lib/View/UserProfile/Template_c/';
		$smarty->config_dir = '../lib/View/UserProfile/Config/';
		$javascript = array(
			'/javascript/jquery/jquery-3.2.1.js',
			'/javascript/userprofile.js',
		);
		$stylesheets = array(
			'/CSS/index.css',
			'/CSS/al_menu.css',
			'/CSS/al_userprofile.css',
		);
		$smarty->assign( 'stylesheets', $stylesheets );
		$smarty->assign( 'javascript', $javascript );	
		$smarty->assign( 'page', 'userprofile');
		$smarty->assign( 'tool_fullname', AL_Utility::TOOL_FULLNAME );
		
		//$this->AssignValues( $smarty );
		//$this->log_frontpage->trace( "logging before smarty load");
		$smarty->display( $smarty->template_dir[0] . 'userprofile.smarty' );
		//$this->log_frontpage->trace( "logging after smarty load");
	 }
	/**
	 * Process Registration started
	 */
	 public function UserRegistration() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called from registration' );
		//echo ( "Going to Registration page");
		global $smarty;
		$smarty->template_dir =  '../lib/View/Registration/Template/';
		$smarty->compile_dir = '../lib/View/Registration/Template_c/';
		$smarty->config_dir = '../lib/View/Registration/Config/';
		$javascript = array(
			'/javascript/jquery/jquery-3.2.1.js',
			'/javascript/registration.js',
		);
		$stylesheets = array(
			'/CSS/index.css',
			'/CSS/al_menu.css',
			'/CSS/al_registration.css',
		);
		$smarty->assign( 'stylesheets', $stylesheets );
		$smarty->assign( 'javascript', $javascript );	
		$smarty->assign( 'tool_fullname', AL_Utility::TOOL_FULLNAME );
		//$this->AssignValues( $smarty );
		//$this->log_frontpage->trace( "logging before smarty load");
		$smarty->display( $smarty->template_dir[0] . 'registration.smarty' );
		//$this->log_frontpage->trace( "logging after smarty load");
	 }
	 
	 /**
	 /* Used to submit new user's registration data
	 */
	 public function SubmitRegistrationInfo() {
		$this->log_frontpage->trace( __FUNCTION__ . ' called' );
		if( isset( $_REQUEST['regusername']) && isset( $_REQUEST['reguserpass'])&& isset( $_REQUEST['regfirstname']) && isset( $_REQUEST['reglastname']) && isset( $_REQUEST['regemail'])) {
			$username = $_REQUEST['regusername'];
			$password = $_REQUEST['reguserpass'];
			$firstname = $_REQUEST['regfirstname'];
			$lastname = $_REQUEST['reglastname'];
			$email = $_REQUEST['regemail'];
			$middlename = isset($_REQUEST['regmiddlename']) ? $_REQUEST['regmiddlename'] : null;
			// if middle name is set set to middle name, otherwise make it null - is what the line above does
		} else {
			$this->log_frontpage->trace( 'bad registration' );
			exit( 'Bad request, handle this.' );
		}
		$json_response = array(
			'data' => 0,
			'message' => 0,
			'success' => 0,
		);
		$register_user = $this->playerManager()->Registration( $username, $password, $firstname, $middlename, $lastname, $email );
		if( $register_user == 'true' ) {
			//$_SESSION['id'] = $this->active_login;
			$json_response['success'] = 1;
		}
		$this->log_frontpage->trace( $json_response, __FUNCTION__ . ' $json_response');
		header('Content-Type: application/json');
		echo( json_encode( $json_response ));
	 }
	 
	 /**
	 /*Currently validates the username is not already used. Could add more functionality to verify other things if needed
	 */
	 public function ValidateRegistrationInfo() {
		 $this->log_frontpage->trace( __FUNCTION__ . ' called' );
		 
		if( isset($_REQUEST['regusername']) ) {
			$new_username = $_REQUEST['regusername'];
			$this->log_frontpage->trace( __FUNCTION__ . ' username passed in: ' . $new_username );
		} else {
			$this->log_frontpage->trace( ' no username to check' );
			exit( 'Bad request, handle this.' );		
		}
		$json_response = array(
			'data' => 0,
			'message' => 0,
			'success' => 0,
		);
		$this->log_frontpage->trace( __FUNCTION__ . ' before ValidateNewUsername' );
		$val_user = $this->playerManager()->ValidateNewUsername( $new_username );
		if( $val_user == 'true' ) {
			//sucess means the user does not exist
			$json_response['success'] = 1;
			$this->log_frontpage->trace( __FUNCTION__ . ' success - no user' );
		} elseif ( $val_user == 'false' ){
			$json_response['success'] = 0;
		}
		$this->log_frontpage->trace( $json_response, __FUNCTION__ . ' $json_response');
		header('Content-Type: application/json');
		echo( json_encode( $json_response ));
	 }
	
	/**
	 * Render the page.
	 */
	public function DisplayPage() {
		$this->log_frontpage->trace( __FUNCTION__ . ' here called');
		global $smarty;
		$this->AssignValues( $smarty );
		$smarty->display( $smarty->template_dir[0] . 'index.smarty' );
	}
}
