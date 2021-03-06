<?php

namespace AuraLight\Model\Manager;
use AuraLight\Common\Utility\AL_Log;
use AuraLight\Common\Utility\AL_Utility;
use AuraLight\Model\Player\AL_Player;

class AL_PlayerManager {
	
	private $log_gamemanager;
	private $player;
	private $player_id;

	// SQL to retrieve player_id for Mr. Menethil
	private static $sql_retrieve_test_player_id = <<<'SQL'
select id from al_player where player_email = 'a.menethil@icecrown.army.mil';
SQL;
	/**
	 *
	 */
	public function __construct(){
		$this->log_gamemanager = new AL_Log( 'GameManager' );
		global $conn;
/*		$result_player_id = pg_query( $conn, static::$sql_retrieve_test_player_id );
		while( $row = pg_fetch_row( $result_player_id )) {
			$this->player_id = $row[0];
		}
		$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ': $this->player_id' );
		$this->player_id = "78db8576-b292-494d-b385-b9bffb5d3887"; */
	}
	/**
	 * Instantiate and return a player object.
	 */
	public function Player() {
		$this->log_gamemanager->trace( __FUNCTION__ . ' called');
		$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ' $this->player_id');
		$this->player = new AL_Player( $this->player_id );
		$this->player->PopulateData();
		$this->player->email();
		$this->player->username();
		$this->player->name_first();
		$this->player->name_middle();
		$this->player->name_last();
		$this->player->password();
		$this->player->get_attributes();
		//var_dump ($this->player);
		return $this->player;
	}
	// SQL to check DB for username/password match
	private static $sql_check_db_username_password = <<<'SQL'
select id, player_username
from al_player
where player_username = $1
and player_password = $2;
SQL;
	/**
	 * Authenticate a user based on a provided username and password combination.
	 *
	 * @param string $username Username provided
	 * @param string $password Password provided
	 * @return mixed $session_id Will return a session ID for a valid user, or null for a failed
	 *	authentication
	 */
	public function Authenticate( $username, $password ) {
		$this->log_gamemanager->trace( __FUNCTION__ . ' called' );
		$this->log_gamemanager->trace( $username, __FUNCTION__ . ' $username' );
		$this->log_gamemanager->trace( $password, __FUNCTION__ . ' $password' );
		global $conn;
		$session_id = null;
		$result_player_id = pg_query_params( $conn, static::$sql_check_db_username_password, array(
			$username,
			$password
		));
		$results = array();
		$pg_results = pg_fetch_all( $result_player_id );
		$this->log_gamemanager->trace( $pg_results, __FUNCTION__ . ' $pg_results' );
		if( !$pg_results ) {
			return null;
		}
		if( count( $pg_results) === 1 ) {
			while( $row = pg_fetch_row( $result_player_id )) {
				$this->player_id = $row[0];
				break;
			}
			$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ' $this->player_id' );
			$session_id = AL_Utility::Session( $this->player_id );
		} else {
			exit( 'Authenticate: ERROR: Too many results returned' );
		}
		$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ': $this->player_id [2]' );
		return $session_id;
	}
	
private static $sql_check_db_username_exists = <<< 'SQL'
select id
from al_player
where player_username = $1;
SQL;

	public function ValidateNewUsername( $username ) {
		$this->log_gamemanager->trace( __FUNCTION__ . ' called');
		$this->log_gamemanager->trace(  $username, __FUNCTION__ . ' $username');
		global $conn;
		$result_player_id = pg_query_params( $conn, static::$sql_check_db_username_exists, array(
			$username
		));
		$results = array();
		$pg_results = pg_fetch_all( $result_player_id );
		$this->log_gamemanager->trace( $pg_results, __FUNCTION__ . ' $pg_results' );
		if( !$pg_results ) {
			$this->log_gamemanager->trace( $username, __FUNCTION__ . ' $username does not exist' );
			return true;
		}
		if( count( $pg_results) === 1 ) {
			while( $row = pg_fetch_row( $result_player_id )) {
				$this->player_id = $row[0];
				break;
			}
			$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ' $this->player_id - username exists' );
			return false;
		} else {
			exit( 'Authenticate: ERROR: Too many results returned' );
		}
	}
	// SQL to insert registration into the al_player table
	private static $sql_insert_db_player_all_info = <<<'SQL'
insert into al_player (player_username, player_password, player_name_first, player_name_middle, player_name_last, player_email)
values ($1, $2, $3, $4, $5, $6) returning id
SQL;


	 /**
	 * Register a user based on a provided string combination.
	 *
	 * @param string $username Username provided
	 * @param string $password Password provided
	 * @param string $firstname First Name provided
	 * @param string $middlename Middle Name potentially provided
	 * @param string $lastname Last Name provided
	 * @param string $email Email provided
	 * @return mixed $session_id Will return a session ID for a valid user, or null for a failed
	 *	authentication
	 */
	public function Registration( $username, $password, $firstname, $middlename, $lastname, $email ) {
		$this->log_gamemanager->trace( __FUNCTION__ . ' called' );
		$this->log_gamemanager->trace( $username, __FUNCTION__ . ' $username' );
		$this->log_gamemanager->trace( $password, __FUNCTION__ . ' $password' );
		$this->log_gamemanager->trace( $firstname, __FUNCTION__ . ' $firstname' );
		$this->log_gamemanager->trace( $middlename, __FUNCTION__ . ' $middlename' );
		$this->log_gamemanager->trace( $lastname, __FUNCTION__ . ' $lastname' );
		$this->log_gamemanager->trace( $email, __FUNCTION__ . ' $email' );
		global $conn;
		$session_id = null;
		$ins_player_id = pg_query_params( $conn, static::$sql_insert_db_player_all_info, array(
			$username,
			$password,
			$firstname,
			$middlename,
			$lastname,
			$email
		));
		
		$this->log_gamemanager->trace( $ins_player_id, __FUNCTION__ . ' $ins_player_id' );
		$pg_results = pg_fetch_all( $ins_player_id );
		$this->log_gamemanager->trace( $pg_results, __FUNCTION__ . ' $pg_results' );
		if( !$pg_results ) {
			return null;
		}
		if( count( $pg_results) === 1 ) {
			while( $row = pg_fetch_row( $ins_player_id )) {
				$this->player_id = $row[0];
				break;
			}
			$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ' $this->player_id' );
		} else {
			exit( 'Authenticate: ERROR: Too many results returned' );
		}
		$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ': $this->player_id [2]' );
		return true;
	}
		
	// SQL to return a player ID given an associated session ID
	private static $sql_retrieve_player_from_session = <<<'SQL'
select id_player from auralight.al_session where id = $1;
SQL;
	/**
	 * Given a session ID, return an associated player object
	 *
	 * @param string $id_session DB ID of a session
	 * @return AL_Player $player Player object associated with given session ID
	 * @return boolean false Return false if no player found
	 */
	public function PlayerBySession( $id_session ) {
		$this->log_gamemanager->trace( __FUNCTION__ . ' called' );
		$this->log_gamemanager->trace( $id_session, __FUNCTION__ . ' $id_session' );
		global $conn;
		$result_player_id = pg_query_params( $conn, static::$sql_retrieve_player_from_session, array(
			$id_session
		));
		$pg_results = pg_fetch_all( $result_player_id );
		if( !$pg_results ) {
			$this->log_gamemanager->trace( __FUNCTION__ . ' No player found for provided session ID.' );
		} else {
			while( $row = pg_fetch_row( $result_player_id )) {
				$this->player_id = $row[0];
			}
			$player = $this->Player();
			return $player;
		}
		return false;
	}
}
