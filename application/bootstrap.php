<?php
// including global autoloader
require_once dirname(__FILE__) . '/../vendor/autoload.php';

// Init config data
$config = array();
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = true;

// Routing
$request_uri = $_SERVER['REQUEST_URI'];
$routes = array();
$routefile = fopen( dirname(__FILE__) . '/../share/config/routes', 'r');
if( $routefile ) {
	while(( $line = fgets( $routefile )) !== false ) {
		$routeComponents = explode( ',', $line );
		$routes[ trim($routeComponents[0]) ] = trim($routeComponents[1]);
	}
}
fclose( $routefile );

Logger::configure(dirname(__FILE__) .'/../share/config/log4php/defaultLog4PHP.xml');

$config['app'] = array(
	'name' => 'AuraLight',
	'name1' => 'Don',
	'name2' => 'Stan',
	'log_default' => Logger::getLogger( 'Default' ),
	'log_frontpage' => Logger::getLogger( 'FrontPage' ),
);

$config['log_config'] = dirname(__FILE__) . '/../share/config/log4php/';

$configFile = dirname(__FILE__) . '/../share/config/defaultConfig.php';

if (is_readable($configFile)) {
	require_once $configFile;
}

// Route redirect
if( in_array( $request_uri, array_keys( $routes ))) {
	$page = new $routes[ $request_uri ]($config, $smarty);
	$page->DisplayPage( $smarty );
} else {
	$greeter = new AuraLight\Controller\FrontPage\FrontPageController($config,$smarty/*,$config['app']['log_default']*/);
	$greeter->DisplayPage($smarty/*,$config['app']['log_default']*/);
	//$log_default->info("Just logging");
}
