<?php

namespace AuraLight\Model\Player;

use AuraLight\Common\Utility\AL_Log;


class AL_Player {

	private $username;
	private	$email;
	private	$name_first;
	private	$name_last;
	private	$name_middle;
	private $player_id;
	

	public function __construct( $player_id) {
		$this->player_id = $player_id;
		
	}
	
	//create a statement (sql) with parameters from above
	private static $sql_email= <<<'SQL'
	select player_email from al_player where id = $1
SQL;

	private static $sql_username= <<<'SQL'
	select player_username from al_player where id = $1
SQL;

	private static $sql_name_first= <<<'SQL'
	select player_name_first from al_player where id = $1
SQL;

	private static $sql_name_middle= <<<'SQL'
	select player_name_middle from al_player where id = $1
SQL;

	private static $sql_name_last= <<<'SQL'
	select player_name_last from al_player where id = $1
SQL;

	
	public function username($new_name=NULL) {
		if(!(isset( $this->username))){
			$results=pg_query_params(static::$sql_username,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_assoc ($results,0);
			$this->username = $row;
		}
		return $this->username;
	}
	
	
	public function email($new_email=NULL) {
		if(!(isset( $this->email))){
			$results=pg_query_params(static::$sql_email,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_assoc ($results,0);
			//var_dump ($row);
			$this->email = $row;
		}
		return $this->email;
	}
	
	public function name_first($new_name_first=NULL) {
		if(!(isset( $his->name_first ))){
			$results=pg_query_params(static::$sql_name_first,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_assoc ($results,0);
			$this->name_first = $row;
		}
		return $this->name_first;
	}
	
	public function name_middle($new_name_middle=NULL) {
		if(!(isset( $his->name_middle ))){
			$results=pg_query_params(static::$sql_name_middle,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_assoc ($results,0);
			$this->name_middle = $row;
		}
		return $this->name_middle;
	}
	
	
	public function name_last($new_name_last=NULL) {
		if(!(isset( $his->name_last ))){
			$results=pg_query_params(static::$sql_name_last,  array(':player_id'=>$this->player_id));
			$row = pg_fetch_assoc ($results,0);
			$this->name_last = $row;
		}
		return $this->name_last;
	}
	
	
	//should this really be in another class? I think so but where do we put it
	public function get_attributes(){
		//First we need to get which accounts are part of the player
		//Next we need to get which toons are part of this account
		$this->accounts = AL_Account::get_account_name();
	}
	
}