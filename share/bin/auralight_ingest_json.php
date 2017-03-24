<?php
$logFileName = 'auralight_initial_ingest_json.log';
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


$file = file_get_contents( 'auralight_ingest_json.json' );
$json = json_decode( $file, true );
print_r( $json, false );
if( $json === null ){
	exit( "\nNULL!\n" );
} else {
	exit( "\nnot null\n");
}


$dbHost = 'localhost';
$dbName = 'AL_Dev';
$dbPass = 'ALDev110PG!';
$dbSchema = 'auralight';
$dbUser = 'auralight';
$dbString = 'host = ' . $dbHost . ' dbname = ' . $dbName . ' user = ' . $dbUser . ' password = ' . $dbPass;
$db = pg_connect( $dbString ) or die( 'Could not connect: ' . pg_last_error());
pg_query( $db, 'set search_path to ' . $dbSchema );
