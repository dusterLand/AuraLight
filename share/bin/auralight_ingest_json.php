<?php
// set DB information
$dbHost = 'localhost';
$dbName = 'AL_Dev';
$dbPass = 'ALDev110PG!';
$dbSchema = 'auralight';
$dbUser = 'auralight';
$dbString = 'host = ' . $dbHost . ' dbname = ' . $dbName . ' user = ' . $dbUser . ' password = ' . $dbPass;
$db = pg_connect( $dbString ) or die( 'Could not connect: ' . pg_last_error());
pg_query( $db, 'set search_path to ' . $dbSchema );

$logFileName = 'auralight_initial_ingest_json.log';
$logFile = fopen( $logFileName, 'a' );
if( !$logFile ) {
	exit( 'Failed to open log file. ');
}
// logging function
function iLog( $message ) {
	global $logFile;
	$dateTime = date( "Y-m-d H:i:s" );
	$logMessage = '[' . $dateTime . '] ' . $message;
	fwrite( $logFile, $logMessage . "\n" );
}

function generateQueryChunk( $value_segment ) {
//	iLog( 'generateQueryChunk() for ' . "\n" . print_r( $value_segment, true ));
	$query_chunk = '';
	$query_package = '';
	$query_type = $value_segment['query_type'];
	$data_type = isset( $value_segment['data_type'] ) ? $value_segment['data_type'] : 'query';
	switch( $query_type ) {
		case 'simple':
			$query_chunk = $value_segment['value'];
//			iLog( '(simple) query chunk: ' . print_r( $query_chunk, true ));
			break;
		case 'complex':
			$query_chunk = generateQueryChunk( $value_segment['value']);
//			iLog( '(complex) query chunk: ' . print_r( $query_chunk, true ));
			break;
		case 'subquery':
			$query_source_values = implode( ', ', $value_segment[ 'source_values' ]);
			$query_chunk = 'select ' . $query_source_values . ' from al_' . $value_segment['source_table'] . ' where ';
			$query_chunks = array();
			for( $i = 0; $i < count( $value_segment['source_parameters'] ); $i++ ) {
				$key = $value_segment['source_parameters'][$i]['key'];
				$value = $value_segment['source_parameters'][$i]['value'];
				switch( gettype( $value )) {
					case 'integer':
						$value_processed = $value;
					case 'string':
						$value_processed = '\'' . $value . '\'';
						break;
					case 'array':
						$value_processed = '( ' . generateQueryChunk( $value ) . ' )';
						break;
					default:
						exit( 'ERROR: generateQueryChunk(): unknown variable type' );
				}
				$query_chunks[] = /*' ' . */$key . ' = ' . $value_processed;
			}
			$query_chunk .= implode( ' and ', $query_chunks );
//			iLog( '(subquery) query chunk: ' . print_r( $query_chunk, true ));
			return $query_chunk;
			break;
		default:
			exit( 'ERROR: generateQueryChunk: Unaccounted query type case' );
			break;
	}
	switch( $data_type ) {
		case 'string':
			$query_package = '\'' . $query_chunk . '\'';
			break;
		case 'integer';
			$query_package = $query_chunk;
			break;
		case 'query':
			$query_package = '( ' . $query_chunk . ' )';
			break;
		case 'null':
			$query_package = 'null';
			break;
		default:
			break;
	}
	return $query_package;
}

$file = file_get_contents( 'auralight_ingest_json.json' );
$json = json_decode( $file, true );

foreach( $json['tables'] as $table ) {
	iLog( 'Starting table ' . $table['name'] . '... ' );
	$insert = 'insert into al_' . $table['name'] . ' ( ';
	$keys = '';
	$values = '';
	$keys = implode( ', ', $table['keys'] );
//	iLog( '$keys: ' . print_r( $keys, true ) );
	$insert .= $keys;
	$insert .= ' ) values ( ';
//	iLog( '$insert: ' . print_r( $insert, true ));
	foreach( $table['values'] as $value_row ) {
//		iLog( '$value_row: ' . print_r( $value_row, true ) );
		$segments = array();
		foreach( $value_row as $value_segment ) {
//			iLog( '$value_segment: ' . print_r( $value_segment, true ) );
//			iLog( 'processed value_segment: ' . print_r( generateQueryChunk( $value_segment ), true ) );
			$segments[] = generateQueryChunk( $value_segment );
//			iLog( 'Last segment: ' . print_r( $segments[count($segments) - 1], true));
		}
		$segments = implode( ', ', $segments );
//		iLog( '$segments: ' . print_r( $segments, true ));
		$full_insert = '' . $insert . $segments . ' );';
		iLog( 'Full insert: ' . print_r( $full_insert, true ));
		pg_query( $db, $full_insert ) or die( 'DB ERROR: ' . pg_last_error());
	}
}

fclose( $logFile );

/*
print_r( $json, false );
if( $json === null ){
	exit( "\nNULL!\n" );
} else {
	exit( "\nnot null\n");
}
*/
