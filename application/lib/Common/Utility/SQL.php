<?php

namespace AuraLight\Common\Utility;

/**
 * Usage (envisioned):
 *	$db = new SQL('auralight');
 *	$query_result = $db->exec( $query, array(
 *		':param1' => $param1,
 *		':param2' => $param2,
 *	);
 */

class SQL {

	private $stream;
	/**
	 * Set stream name
	 */
	public function __construct( $stream ) {
		$this->stream = $stream;
	}
	/**
	 * Execute given query with given parameters, if pressent.
	 */
	public function exec( $query, $parameters = null ) {
	
	}
}