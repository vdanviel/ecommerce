<?php 
require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

//$app->config('debug', true);


#CLIENT ROTES
$app->get('/', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/index.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

$app->get('/lista-produtos', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/lista-produtos.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

$app->get('/carrinho', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/carrinho.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

$app->get('/esqueci-a-senha', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/r-senha.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

$app->get('/login', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/login.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

$app->get('/pagamento', function() {
    
	require_once("vendor/PERSONAL/template/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/pagamento.php");
	require_once("vendor/PERSONAL/template/header-footer/footer.php");

});

#ADMIN ROTES


$app->run();

 ?>