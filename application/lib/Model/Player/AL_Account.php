<?php

namespace AuraLight\Model\Player;

use AuraLight\Common\Utility\AL_Log;


class AL_Account {

	private $name;
	
	function __construct($account_name) {
	//Should we pass in player name to get the account name(s)
		$this->name = $account_name;
	}
	
	function set_account_name($new_account_name) {
		$this->name = $new_account_name;
	}
	
	function get_account_name() {
		return $this->name;
	}
}