<?php

namespace AuraLight\Model\Manager;
use AuraLight\Common\Utility\AL_Log;
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
		$result_player_id = pg_query( $conn, static::$sql_retrieve_test_player_id );
		while( $row = pg_fetch_row( $result_player_id )) {
			$this->player_id = $row[0];
		}
		$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ': $this->player_id' );
//		$this->player_id = "78db8576-b292-494d-b385-b9bffb5d3887";
	}
	/**
	 *
	 */
	public function displayManager (){
		$this->log_gamemanager->trace( __FUNCTION__ . ' called');
		$this->player = new AL_Player($this->player_id);
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
	 *
	 */
	public function Authenticate( $username, $password ) {
		$this->log_gamemanager->trace( __FUNCTION__ . ' called' );
		$this->log_gamemanager->trace( $username, __FUNCTION__ . ' $username' );
		$this->log_gamemanager->trace( $password, __FUNCTION__ . ' $password' );
		global $conn;
		$result_player_id = pg_query_params( $conn, static::$sql_check_db_username_password, array(
			$username,
			$password
		));
		$results = array();
		$pg_results = pg_fetch_all( $result_player_id );
		$this->log_gamemanager->trace( $pg_results, __FUNCTION__ . ' $pg_results' );
		if( count( $pg_results ) > 1 ) {
			exit( 'Authenticate: ERROR: Too many results returned' );
		} else {
			// YOU'RE HERE, JASON
			// generate new player here?
		}
		while( $row = pg_fetch_row( $result_player_id )) {
			$this->player_id = $row[0];
			break;
		}
		$this->log_gamemanager->trace( $this->player_id, __FUNCTION__ . ': $this->player_id [2]' );
		$success = false;
		return $success;
	}
}
