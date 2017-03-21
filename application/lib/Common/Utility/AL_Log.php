<?php

namespace AuraLight\Common\Utility;

class AL_Log {
	
	private $streamName;
	/**
	 * 
	 */
	public function __construct( $streamName ) {
		$this->streamName = $streamName;
	}
	/**
	 * TODO: Implement severity fence handling
	 */
	public function log( $data, $message = null, $severity = 'trace' ) {
		$dateTime = date( "Y-m-d H:i:s" );
		$logFile = fopen( '../var/logs/' . trim($this->streamName) . '.log', 'a' );
		if( $logFile !== false ) {
			$logMessage = '[' . $dateTime . '] ';
			if( isset( $message )) {
				$logMessage .= $message . ': ';
			}
			$logMessage .= print_r( $data, true );
			fwrite( $logFile, $logMessage . "\n" );
			fclose( $logFile );
		} else {
			// TODO: Make some kind of exception handler to exit more gracefully
			exit( __FILE__ . ': failed to obtain resource' );
		}
	}
	/**
	 *
	 */
	public function warn( $data, $message = null ) {
		$this->log( $data, $message, 'warn' );
	}
	/**
	 *
	 */
	public function info( $data, $message = null ) {
		$this->log( $data, $message, 'info' );
	}
	/**
	 *
	 */
	public function trace( $data, $message = null ) {
		$this->log( $data, $message, 'trace' );
	}
}