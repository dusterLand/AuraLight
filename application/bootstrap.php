<?php
// start session
session_start();
// include global autoloader
require_once dirname(__FILE__) . '/../vendor/autoload.php';
// include bootstrap logger
require_once dirname(__FILE__) . '/../application/al_bs_log.php';

// Init config data
$config = array();
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = true;

Logger::configure(dirname(__FILE__) .'/../share/config/log4php/defaultLog4PHP.xml');

$config['app'] = array(
	'name' => 'AuraLight',
	'name1' => 'Don',
	'name2' => 'Stan',
	'log_default' => Logger::getLogger( 'Default' ),
	'log_frontpage' => Logger::getLogger( 'FrontPage' ),
	'log_registration' => Logger::getLogger( 'Registration' ),
);

$config['log_config'] = dirname(__FILE__) . '/../share/config/log4php/';
$ini = parse_ini_file(dirname(__FILE__) . '/../share/config/defaultConfig.ini');

$configFile = dirname(__FILE__) . '/../share/config/defaultConfig.php';
if (is_readable($configFile)) {
	require_once $configFile;
}

$connString = "host=" . $ini['db_host'] . " dbname=" . $ini['db_name']. " user=" . $ini['db_user'] . " password=" . $ini['db_password'];
$conn = pg_connect($connString)
	or die('Could not connect: ' . pg_last_error());
if( isset( $ini['db_schema'])) {
	$result = pg_query( $conn, 'set search_path to ' . $ini['db_schema']);
}

// call router
require_once dirname(__FILE__) . '/../application/al_router.php';
	
//phpinfo();
