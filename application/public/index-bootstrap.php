<?php

require_once dirname(__FILE__) . '/../bootstrap.php';

$smarty->get('/testfrontpagecontroller()', function() {
	$greeter = new TestApp\FrontPage\FrontPageController();
	echo $greeter->DisplayPage();
	\\$log_default->info("Just logging");
});


$smarty->run();