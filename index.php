<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

//$app->config('debug', true);

$app->get('/a', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/index.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

$app->get('/listaproduto', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/lista-produtos.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

	echo "okay.";

});

$app->run();

 ?>