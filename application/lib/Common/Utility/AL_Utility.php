<?php

namespace AuraLight\Common\Utility;

class AL_Utility {
	const TOOL_ACRONYM = 'AL';
	const TOOL_FULLNAME = 'AuraLight';
	// SQL to check for a session iD
	private static $sql_check_session_id = <<<'SQL'
select id from al_session where id_player = $1
SQL;
	// SQL to create new session ID
	private static $sql_create_session_id = <<<'SQL'
insert into al_session (
	id_player
) values (
	$1
) returning id
SQL;
	/**
	 * Return a pre-existing or new session ID for an authenticated player.
	 *
	 * @param string $id_player DB ID for an authenticated player
	 * @return string $existing_session DB ID for the player's session
	 */
	public static function Session( $id_player ) {
//		print_r( 'incoming $id_player: ' . var_dump( $id_player . "\n\n" ));
		global $conn;
		$existing_session;
		$result_existing_session = pg_query_params( $conn, static::$sql_check_session_id, array(
			$id_player
		));
		$pg_results = pg_fetch_all( $result_existing_session );
		if( !$pg_results ) {
			exit( 'No results and shit.' );  <-- YOU ARE HERE
			$result_existing_session = pg_query_params( $conn, static::$sql_create_session_id, array(
				$id_player
			));
		}
		$pg_results2 = pg_fetch_all( $result_existing_session );
		print_r( var_dump( $pg_results2 ));
		while( $row = pg_fetch_row( $result_existing_session )) {
			$existing_session = $row[0];
			break;
		}
		return $existing_session;
	}
}
