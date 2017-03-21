<?php

namespace AuraLight\Model\Player;

use AuraLight\Common\Utility\AL_Log;


class AL_Account {

	private $account_name;
	
	public function __construct() {
	//Should we pass in player name to get the account name(s)
		
	}
	
	private static $sql_account_name= <<<'SQL'
	select account_name from al_account where id_player_owner = $1
SQL;
	
	public function account_name($new_account_name=NULL) {
		if(!(isset( $this->account_name ))){
			//$results=pg_query_params(static::$sql_account_name,  array(':player_id'=>$player_id));
			//$row = pg_fetch_assoc ($results);
			$this->account_name = $new_account_name;
		}
		return $this->account_name;
	}
	
}