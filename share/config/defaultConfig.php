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


$usertable="your_tablename";
$yourfield = "your_field";
 
//Connect to the database
$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['password'],$config['db']['name']);
