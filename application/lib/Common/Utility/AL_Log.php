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
	public function log( $message, $severity ) {
		$dateTime = date( "Y-m-d H:i:s" );
		$logFile = fopen( '../var/logs/' . trim($this->streamName) . '.log', 'a' );
		if( $logFile !== false ) {
			$logMessage = '[' . $dateTime . '] ' . $message;
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
	public function warn( $message ) {
		$this->log( $message, 'warn' );
	}
	/**
	 *
	 */
	public function info( $message ) {
		$this->log( $message, 'info' );
	}
	/**
	 *
	 */
	public function trace( $message ) {
		$this->log( $message, 'trace' );
	}
}