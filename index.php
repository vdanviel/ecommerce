<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \PERSONAL\USER\User;

$app = new Slim();

//$app->config('debug', true);


#CLIENT ROTES
$app->get('/', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/index.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/lista-produtos', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/lista-produtos.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/carrinho', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/carrinho.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/esqueci-a-senha', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/r-senha.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/login', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/login.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php.php");
});

$app->get('/pagamento', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/pagamento.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

#ADMIN ROTES
$app->get('/admin', function () {

	User::verifylogin();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/index.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

#login-functions/logout
$app->get('/admin/login', function () {

	require_once("vendor/PERSONAL/template/adm-site/login.php");
});

$app->post('/admin/login', function () {

	$email = $_POST['email'];
	$password = $_POST['password'];

	User::login($email, $password);
	header("location: http://localhost/ecommerce/admin");
	exit;
});

$app->get('/admin/logout', function () {

	User::logout();
	exit;
});

#users
$app->get('/admin/users', function () {

	User::verifylogin();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/users/create', function () {

	User::verifylogin();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users-create.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/users/create', function () {

	User::verifylogin();

	$user = new User();

	try {
		$_POST['inadmin'] = (isset($_POST['inadmin']) ? '1' : '0');
		$user->setdata($_POST);
		$user->registeruser();

		$statusR = "SUCCESS";
	} catch (\Throwable $e) {
		$statusR = "ERROR: ".$e->getMessage();
	}
	
	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/users/:id/delete', function ($id) {
	User::verifylogin();

	$user = new User;
		
	try {
		$user->deleteuser($id);
		
		$statusD = "SUCCESS";
	} catch (\Throwable $e) {
		$statusD = "ERROR: ".$e->getMessage();
	}

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");

});

$app->get('/admin/users/:id', function () {

	User::verifylogin();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users-update.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/users/:id', function ($id) {

	User::verifylogin();

	$user = new User();

	$dbuser = User::findoneuser($id);

	try {
		$_POST['despassword'] = $dbuser[0]['despassword'];
		$_POST['inadmin'] = (isset($_POST['inadmin']) ? '1' : '0');
		$user->setdata($_POST);
		$user->edituser();

		$statusE = "SUCCESS";
	} catch (\Throwable $e) {
		$statusE = "ERROR: ".$e->getMessage();
	}

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->run();
