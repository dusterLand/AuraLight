<?php

namespace AuraLight\CharacterManager;

use AuraLight\Common\Utility\AL_Log;

class AL_CharacterManager {

	private $log_charactermanager;
	/**
	 *
	 */
	public function __construct() {
		$this->log_charactermanager = new AL_Log( 'CharacterManager' );
	}

}