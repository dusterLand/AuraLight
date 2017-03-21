<?php

namespace AuraLight\Model\Player;

use AuraLight\Common\Utility\AL_Log;


class AL_Account {

	private $account_name;
	private $log_account;
	
	public function __construct() {
		$this->log_account = new AL_Log( 'Account' );
		// Should we pass in player name to get the account name(s)
	}
	
	// TODO: Remove this if it's no longer needed
	private static $sql_account_name = <<<'SQL'
	select account_name from al_account where id_player_owner = $1
SQL;
	
	public function account_name($new_account_name=NULL) {
		$this->log_account->trace( __FUNCTION__ . ' called');
		if(!(isset( $this->account_name ))){
			//$results=pg_query_params(static::$sql_account_name,  array(':player_id'=>$player_id));
			//$row = pg_fetch_assoc ($results);
			$this->account_name = $new_account_name;
		}
		return $this->account_name;
	}
	
}
