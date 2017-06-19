<?php

namespace AuraLight\Model\Player;

use AuraLight\Common\Utility\AL_Log;
use AuraLight\Model\Player\AL_Account;


class AL_Player {

	private $username;
	private	$email;
	private $log_player;
	private	$name_first;
	private	$name_last;
	private	$name_middle;
	private $player_id;
	private $accounts;
	/**
	 *
	 */
	public function __construct( $player_id) {
		$this->log_player = new AL_Log( 'Player' );
		$this->player_id = $player_id;
	}
	// create a statement (sql) with parameters from above
	private static $sql_email = <<<'SQL'
select player_email from al_player where id = $1
SQL;
	//
	private static $sql_username = <<<'SQL'
select player_username from al_player where id = $1
SQL;
	//
	private static $sql_name_first = <<<'SQL'
select player_name_first from al_player where id = $1
SQL;
	//
	private static $sql_name_middle = <<<'SQL'
select player_name_middle from al_player where id = $1
SQL;
	//
	private static $sql_name_last = <<<'SQL'
select player_name_last from al_player where id = $1
SQL;
	//
	private static $sql_password = <<<'SQL'
select player_password from al_player where id = $1
SQL;
	//
	private static $sql_account_name = <<<'SQL'
select account_name from al_account where id_player_owner = $1
SQL;
	/**
	 *
	 */
	public function username($new_name=NULL) {
		$this->log_player->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->username))){
			$results=pg_query_params(static::$sql_username,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_row ($results);
			$this->username = $row[0];
		}
		return $this->username;
	}
	/**
	 *
	 */
	public function email($new_email=NULL) {
		$this->log_player->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->email))){
			$results=pg_query_params(static::$sql_email,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_row ($results);
			//var_dump ($row);
			$this->email = $row[0];
		}
		return $this->email;
	}
	/**
	 *
	 */
	public function name_first($new_name_first=NULL) {
		$this->log_player->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->name_first ))){
			$results=pg_query_params(static::$sql_name_first,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_row ($results);
			$this->name_first = $row[0];
		}
		return $this->name_first;
	}
	/**
	 *
	 */
	public function name_middle($new_name_middle=NULL) {
		$this->log_player->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->name_middle ))){
			$results=pg_query_params(static::$sql_name_middle,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_row ($results);
			$this->name_middle = $row[0];
		}
		return $this->name_middle;
	}
	/**
	 *
	 */
	public function name_last($new_name_last=NULL) {
		$this->log_player->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->name_last ))){
			$results=pg_query_params(static::$sql_name_last,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_row ($results);
			$this->name_last = $row[0];
		}
		return $this->name_last;
	}
	/**
	 *
	 */
	public function password($new_player=NULL) {
		$this->log_player->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->player ))){
			$results=pg_query_params(static::$sql_password,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_row ($results);
			$this->password = $row[0];
		}
		return $this->password;
	}
	/**
	 *
	 */
	//should this really be in another class? I think so but where do we put it
	public function get_attributes(){
		$this->log_player->trace( __FUNCTION__ . ' called');
		// First we need to get which accounts are part of the player
		// Next we need to get which toons are part of this account
		// $this->player = new AL_Player($this->player_id);
		if(!(isset( $this->accounts ))){
			$results = pg_query_params(static::$sql_account_name, array(':player_id'=>$this->player_id));
			//exit(print_r(count($results),true));
			if( !$results ) {
				return null;
			}
			while($row = pg_fetch_assoc($results)) {
				$this->log_player->trace($row, __FUNCTION__ . ' $row');
				$tmp_account = new AL_Account();
				$tmp_account->account_name($row['account_name']);
				$this->accounts[] = $tmp_account;
			}
		}
		$this->log_player->trace($this->accounts, __FUNCTION__ . ' $this->accounts');
		//exit(print_r(count($this->accounts),true));
		return $this->accounts;
		//var_dump ($this->accounts);
	}
	// SQL to retrieve all available player data
	private static $sql_retrieve_player_data = <<<'SQL'
SQL;
	/**
	 * Populate all available player data.
	 */
	public function PopulateData() {
		$this->log_player->trace( __FUNCTION__ . ' called');
	}
}
