<?php
// Routing
$request_uri = $_SERVER['REQUEST_URI'];
al_bs_log( $request_uri, '$request_uri' );

$routes = array();
$routefile = fopen( dirname(__FILE__) . '/../share/config/routes', 'r');
if( $routefile ) {
	while(( $line = fgets( $routefile )) !== false ) {
		$routeComponents = explode( ', ', $line );
		$routes[ trim($routeComponents[0]) ] = trim($routeComponents[1]);
	}
}
fclose( $routefile );

al_bs_log( $routes, '$routes' );
al_bs_log( (string)($request_uri), 'casted to string' );
al_bs_log( array_keys( $routes ), 'array keys' );
// hackish BS to make this match preg_matches below
$request_uri = '\'' . $request_uri . '\'';

if( in_array( $request_uri, array_keys( $routes ))) {
	al_bs_log( 'URI is in routes');
	$request = $_REQUEST;
	$destination_segments = explode( '\\', $routes[ $request_uri ] );
	al_bs_log( $destination_segments[ count( $destination_segments ) - 1 ], 'second to last segment' );
	if( preg_match( '/Controller/', $destination_segments[ count( $destination_segments ) - 1 ])) {
		al_bs_log( 'Controller display called' );
		$targetController = new $routes[ $request_uri ]();
		al_bs_log( $targetController, 'Controller object' );
//		$targetController->displayPage();
		$targetFunction = 'displayPage';
	} else if( preg_match( '/Controller/', $destination_segments[ count( $destination_segments ) - 2 ])) {
		al_bs_log( 'Controller function called' );
		$targetFunction = array_pop( $destination_segments );
		$targetController = implode( '\\', $destination_segments );
		al_bs_log( $targetController, 'Controller route' );
		al_bs_log( $targetFunction, 'Controller function' );
	}
	$controllerObj = new $targetController( $smarty );
	al_bs_log( $targetController, 'Controller object' );
	$controllerObj->$targetFunction();
} else {
	al_bs_log( 'URI is NOT in routes, display front page' );
	$targetController = new AuraLight\Controller\FrontPage\FrontPageController( $smarty );
	$targetController->DisplayPage( $smarty );
}