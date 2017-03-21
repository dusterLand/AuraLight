<?php

$dbHost = 'localhost';
$dbName = 'AL_Dev';
$dbPass = 'ALDev110PG!';
$dbSchema = 'auralight';
$dbUser = 'auralight';
$dbString = 'host = ' . $dbHost . ' dbname = ' . $dbName . ' user = ' . $dbUser . ' password = ' . $dbPass;
$db = pg_connect( $dbString ) or die( 'Could not connect: ' . pg_last_error());
pg_query( $db, 'set search_path to ' . $dbSchema );

$logFileName = 'auralight_initial_ingest.log';
$logFile = fopen( $logFileName, 'a' );
if( !$logFile ) {
	exit( 'Failed to open log file. ');
}

function iLog( $message ) {
	global $logFile;
	$dateTime = date( "Y-m-d H:i:s" );
	$logMessage = '[' . $dateTime . '] ' . $message;
	fwrite( $logFile, $logMessage . "\n" );
}

function generateSelect( $matches ) {
	global $logFile;
//	iLog( '$matches: ' . print_r( $matches, true ));
	$targetTable = $matches[1];
	$targetField = $matches[2];
	$nextCheck = preg_match( '/^.*\[@([a-z_]*)\[(.*)\]\]$/', $targetField, $nextMatches );
	if( !( $nextCheck === 0 || count( $nextMatches ) === 0 )) {
		$select = generateSelect( $nextMatches );
	}
	$multiArgCheck = preg_match( '/&/', $targetField, $multiArgMatches );
	if( !( $multiArgCheck === 0 )) {
		$queries = explode( '&', $targetField );
		$select = '( select id from al_' . $targetTable . ' where ';
		for( $i = 0; $i < count( $queries ); $i++ ) {
			$multiFields = explode( '=', $queries[ $i ] );
			if( (count( $queries ) - $i ) !== 1 ) {
				$select = $select . $multiFields[0] . ' = \'' . $multiFields[1] . '\' and ';
			} else {
				$select = $select . $multiFields[0] . ' = \'' . $multiFields[1] . '\' )';
			}
		}
		return $select;
	}
	$fields = explode( '=', $targetField );
	if( isset( $select ) && $select !== '' ) {
		$select = '( select id from al_' . $targetTable . ' where ' . $fields[0] . ' = ' . $select . ' )';
	} else {
		$select = '( select id from al_' . $targetTable . ' where ' . $fields[0] . ' = \'' . $fields[1] . '\' )';
	}
	return $select;
}

function parseValue( $value ) {
	global $logFile;
	$matches = array();
	$keyMatch = preg_match( '/^\'@([a-z_]*)\[(.*)\]\'$/', $value, $matches );
//	iLog( '$matches: ' . print_r( $matches, true ));
	if( $keyMatch === 0 || count( $matches ) === 0 ) {
		return $value;
	} else {
		$select = generateSelect( $matches );
		return $select;
	}
}

function generateQuery( $tableName, $tableKeys, $tableValues ) {
	$part_1 = 'insert into al_' . strtolower( $tableName ) . ' ( ';
	$part_2 = '';
	for( $i = 0; $i < count( $tableKeys ); $i++ ) {
		if( (count( $tableKeys ) - $i ) !== 1 ) {
			$part_2 = $part_2 . $tableKeys[$i] . ', ';
		} else {
			$part_2 = $part_2 . $tableKeys[$i];
		}
	}
	$part_3 = ' ) values ( ';
	for( $i = 0; $i < count( $tableValues ); $i++ ) {
		if( (count( $tableValues ) - $i ) !== 1 ) {
			$part_3 = $part_3 . parseValue( $tableValues[$i] ) . ', ';
		} else {
			$part_3 = $part_3 . parseValue( $tableValues[$i] ) . ' );';
		}
	}
	$statement = $part_1 . $part_2 . $part_3;
	return $statement;
}


$currentTable = '';
$lineNumber = 0;
$insertMode = false;
$keys = array();
$sourceFile = fopen( '../sql/AL_data_initial', 'r' );
if( $sourceFile ) {
	while(( $line = fgets( $sourceFile )) !== false ) {
		$lineNumber++;
		$line = trim( $line );
		switch( $line ) {
			case '---':
				$currentTable = '';
				$insertMode = false;
				$keys = array();
				break;
			case '-':
				$insertMode = true;
				break;
			default:
				if( $insertMode === true ) {
					$parameters = explode( ',', $line );
					if( count( $parameters ) !== count( $keys )) {
						iLog( 'Line ' . $lineNumber . ': WARNING: key count does not match value count (' . count( $parameters ) . ' for ' . count( $keys ) . ')' );
					} else {
						$select = generateQuery( $currentTable, $keys, $parameters );
						iLog( 'Line ' . $lineNumber . ': SQL statement: ' . "\n" . $select );
						pg_query( $db, $select ) or die( 'DB ERROR: ' . pg_last_error());
					}
				} else {
					$matches = array();
					$match_success = preg_match( '/([A-Z_]*)\s\S+\s(.*)/', $line, $matches );
					if( $match_success === false || count( $matches ) === 0 ) {
//						iLog( 'Line ' . $lineNumber . ': WARNING: match failure' );
					} else {
						$currentTable = $matches[1];
						iLog( '$currentTable: ' . $currentTable );
						$keys = explode( ', ', $matches[2] );
//						iLog( '$keys: ' . print_r( $keys, true ));
					}
				}
				break;
		}
	}
} else {
	exit( 'Failed to open source file.' );
}
fclose( $sourceFile );
fclose( $logFile );
