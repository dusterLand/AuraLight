<?php


define('AppCacheEnable', false);
$config['db']= array(
	'driver'	=> 'mysql',
	'host'     => 'localhost',
    'port'     => '3306',
    'user'     => 'auralight',
    'password' => 'NewPass',
    'name'     => 'al_dev'
);

//5432 - postgres port
$connString = "host=" . $config['db']['host'] . " dbname=" . $config['db']['name'] . " user=" . $config['db']['user'] . " password=" . $config['db']['password'];
$conn = pg_connect($connString)
    or die('Could not connect: ' . pg_last_error());
 
//Connect to the database
//$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['password'],$config['db']['name']);
