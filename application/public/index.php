<?php

require_once dirname(__FILE__) . '/../bootstrap.php';

$greeter = new AuraLight\FrontPage\FrontPageController($config,$smarty,$config['app']['log_default']);
$greeter->DisplayPage($smarty,$config['app']['log_default']);
//$log_default->info("Just logging");
