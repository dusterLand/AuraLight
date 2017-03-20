<?php

namespace AuraLight\Model\Player;

use AuraLight\Common\Utility\AL_Log;


class AL_Account {

	private $account_name;
	
	function __construct($account_name) {
	//Should we pass in player name to get the account name(s)
		$this->account_name = $account_name;
	}
	
	private static $sql_account_name= <<<'SQL'
	select account_name from al_account where id_player_owner = $1
SQL;
	
	public function account_name($player_id,$new_account_name=NULL) {
		if(!(isset( $his->account_name ))){
			$results=pg_query_params(static::$sql_account_name,  array(':player_id'=>$player_id));
			$row = pg_fetch_assoc ($results);
			$this->account_name = $row;
		}
		return $this->account_name;
	}
	
}