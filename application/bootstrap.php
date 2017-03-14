<?php
//including global autoloader
require_once dirname(__FILE__) . '/../vendor/autoload.php';


//Init conifg data
$config = array();


$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = true;
$smarty->template_dir =  '../View/FrontPage/Template/';
$smarty->compile_dir = '../View/FrontPage/Template_c/';
$smarty->config_dir = '../View/FrontPage/Config/';

$config['app'] = array(
	'name' => 'AuraLight',
	'name1' => 'Don',
	'name2' => 'Stan',
	'logConfFile' => Logger::configure(dirname(__FILE__) .'/../share/config/log4php/defaultLog4PHP.xml'),
	'log_default' => Logger::getLogger( 'Default' )
);
//$configFile = dirname(__FILE__) . '/../config/defaultConfig.php';
$configFile = dirname(__FILE__) . '../share/config/defaultConfig.php';

if (is_readable($configFile)) {
	require_once $configFile;
}


		
