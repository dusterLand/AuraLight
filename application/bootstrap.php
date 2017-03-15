<?php
//including global autoloader
require_once dirname(__FILE__) . '/../vendor/autoload.php';

//Init config data
$config = array();

$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = true;

Logger::configure(dirname(__FILE__) .'/../share/config/log4php/defaultLog4PHP.xml');

$config['app'] = array(
	'name' => 'AuraLight',
	'name1' => 'Don',
	'name2' => 'Stan',
	'log_default' => Logger::getLogger( 'Default' )
);

$configFile = dirname(__FILE__) . '/../share/config/defaultConfig.php';

if (is_readable($configFile)) {
	require_once $configFile;
}
