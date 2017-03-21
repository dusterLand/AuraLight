<?php
// Bootstrap logging
function al_bs_log( $data, $message = null ) {
	$dateTime = date( "Y-m-d H:i:s" );
	$logFile = fopen( dirname( __FILE__ ) . '/bootstrap.log', 'a' );
	if( $logFile ) {
		$logMessage = '[' . $dateTime . '] ';
		if( isset( $message )) {
			$logMessage .= $message . ': ';
		}
		$logMessage .= print_r( $data, true );
		fwrite( $logFile, $logMessage . "\n" );
	} else {
		exit( __FILE__ . ': Failed to open log file.' );
	}
}
