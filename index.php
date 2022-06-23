<?php 

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$db = new PERSONAL\DB\DBconnect();

	$result = $db->select("SELECT * FROM tb_users");

	echo json_encode($result);

});

$app->run();

 ?>