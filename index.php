<?php
session_start();
require_once("vendor/autoload.php");

use PERSONAL\Category;
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

    $data = \PERSONAL\Product::listdata();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/lista-produtos.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/category/:id', function($id){

    $data = Category::findonecategory($id);

    require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/client-site/category.php");
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

#login-functions
$app->get('/admin/login', function () {
	require_once("vendor/PERSONAL/template/adm-site/login.php");
});

$app->post('/admin/login', function () {

	$email = $_POST['email'];
	$password = $_POST['password'];

	var_dump($_POST);

	User::login($email, $password);
	header("location: http://localhost/ecommerce/admin");
	exit;
});

$app->get('/admin/forgot', function(){

	require_once("vendor/PERSONAL/template/adm-site/forgot-insert.php");

});

$app->post('/admin/forgot', function(){
	User::emailrecovery($_POST["email"]);

	header('location: http://localhost/ecommerce/admin/forgot/sent');
	exit;
});

$app->get('/admin/forgot/reset', function(){

	$user = User::userdecryptforgot($_GET["code"]);

	require_once("vendor/PERSONAL/template/adm-site/forgot-reset.php");

});

$app->post('/admin/forgot/reset', function(){

	$user = User::userdecryptforgot($_GET["code"]);

	User::setforgotuser($user["idrecovery"]);

	User::changepassword($_POST["password"],$user["iduser"]);

	require_once("vendor/PERSONAL/template/adm-site/forgot-reset-success.php");

});

$app->get('/admin/forgot/sent', function(){

	require_once("vendor/PERSONAL/template/adm-site/forgot-sent.php");

});

$app->get('/admin/logout', function () {

	User::logout();
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
		$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT);
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

$app->get('/admin/users/:id', function ($id) {

	User::verifylogin();

	$data = User::findoneuser($id);

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users-update.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/users/:id', function ($id) {

	User::verifylogin();

	$user = new User();

	$data = User::findoneuser($id);

	try {
		$_POST['despassword'] = $data[0]['despassword'];
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

#categories
$app->get('/admin/categories', function(){

	User::verifylogin();

	Category::listdata();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/categories/create', function(){

	User::verifylogin();

	Category::listdata();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories-create.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/categories/create', function(){

	User::verifylogin();

	$category = new Category();

	try {

		$category->setdata($_POST);

		$statusR = $category->registercategory();
	} catch (\Throwable $e) {
		$statusR = "ERROR: ".$e->getMessage();
	}

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/categories/:id', function($id){

	User::verifylogin();

	$data = Category::findonecategory($id);
	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories-update.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/categories/:id', function($id){

	User::verifylogin();

    $category = new Category();

	try {
        $category->setdata($_POST);
        $category->editcategory($id);

		$statusE = "SUCCESS";
	} catch (\Throwable $e) {
		$statusE = "ERROR: ".$e->getMessage();
	}
	
	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/categories/:id/delete', function($id){

	User::verifylogin();

	$category = new Category();

	try {
		$category->deletecategory($id);

		$statusD = "SUCCESS";
	} catch (\Throwable $e) {
		$statusD = "ERROR: ".$e->getMessage();
	}

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

#products
$app->get('/admin/products', function(){
    User::verifylogin();

    $data = \PERSONAL\Product::listdata();

    require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/adm-site/products.php");
    require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/products/create', function(){
    User::verifylogin();

    require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/adm-site/products-create.php");
    require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/products/create', function(){
    User::verifylogin();

	$data = \PERSONAL\Product::listdata();

   	$product = new \PERSONAL\Product();

	if ($_POST['desproduct'] == null ||
		$_POST['vlprice'] == null ||
		$_POST['vlwidth'] == null ||
		$_POST['vlheight'] == null ||
		$_POST['vllength'] == null ||
		$_POST['vlweight'] == null ||
		$_POST['desurl'] == null ||
		$_FILES['imgproduct'] == null
		) {
			echo "<script>alert('Nenhum dos campos podem estar vazio.')</script>";
			require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
			require_once("vendor/PERSONAL/template/adm-site/products-create.php");
			require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
			exit;
	}else{
			try {
				$product->setdata($_POST);
				$product->registerproduct();
		
				$statusR = "SUCCESS";
			} catch (\Throwable $e) {
				$statusR = "ERROR: ".print_r($e);
			} 
	}

    require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/adm-site/products.php");
    require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->run();
