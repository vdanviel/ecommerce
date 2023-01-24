<?php
session_start();
require_once("vendor/autoload.php");

use PERSONAL\Category;
use PERSONAL\Product;
use PERSONAL\Cart;
use PERSONAL\TEMPLATE\Visual;
use \Slim\Slim;
use \PERSONAL\USER\User;
use Slim\Exception\NotFoundException;

$app = new Slim();

//$app->config('debug', true);


#CLIENT ROTES
$app->get('/', function () {

	$product = Product::listdata();
 	$visual = new Visual();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/index.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/lista-produtos/:page', function ($page) {

	$itensperpage = 6;
	
	$product_class = new Product();

	$datainfoproduct = $product_class->listpageitens_products($itensperpage,$page);
	$product = $datainfoproduct[0];
	$pages = $datainfoproduct[1];
	
	$next = $page + 1;
	$previous = $page - 1;

	$visual = new Visual();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/lista-produtos.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/product/:url', function (string $url) {

	$productdetail = Product::productdetail($url);

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/product-detail.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
}); 

$app->get('/category/:id/:page', function($id,$page){

	$visual = new Visual();
	$category_class = new Category();

	$category = $category_class->findonecategory($id);

	$datainfocategory = $category_class->listpageitens_category($id,6,$page);

	$productscategory = $datainfocategory[0];
	$pages = $datainfocategory[1];

	$next = $page + 1;
	$previous = $page - 1;

    require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/client-site/category.php");
    require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/carrinho', function () {

	$visual = new Visual();

	$cart = Cart::getcartfromsession();

	$cart_products = $cart->listcartproducts();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/carrinho.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/carrinho/:idproduct/add', function ($id) {

	$product = new Product();

	$product_result = $product->findoneproduct($id);

	$cart = Cart::getcartfromsession();

	$cart->addproduct($product_result);

	header('location:http://localhost/ecommerce/carrinho');
	exit;
});


$app->get('/carrinho/:idproduct/remove', function ($id) {

	$product = new Product();

	$product_result = $product->findoneproduct($id);

	$cart = Cart::getcartfromsession();

	$cart->removeproduct($product_result);

	header('location:http://localhost/ecommerce/carrinho');
	exit;
});

$app->get('/carrinho/:idproduct/removeall', function ($id) {

	$product = new Product();

	$product_result = $product->findoneproduct($id);

	$cart = Cart::getcartfromsession();

	$cart->removeproduct($product_result, true);

	header('location:http://localhost/ecommerce/carrinho');
	exit;
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

	User::verifylogintemplate();

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

	User::verifylogintemplate();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/users/create', function () {

	User::verifylogintemplate();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users-create.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/users/create', function () {

	User::verifylogintemplate();

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
	User::verifylogintemplate();

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

	User::verifylogintemplate();

	$data = User::findoneuser($id);

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/users-update.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/users/:id', function ($id) {

	User::verifylogintemplate();

	$user = new User();

	$data = User::findoneuser($id);

	try {
		$_POST['despassword'] = $data[0]['despassword'];
		$_POST['inadmin'] = (isset($_POST['inadmin']) ? '1' : '0');
		$user->setdata($_POST);
		$user->edituser($id);

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

	User::verifylogintemplate();

	Category::listdata();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/categories/create', function(){

	User::verifylogintemplate();

	Category::listdata();

	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories-create.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/categories/create', function(){

	User::verifylogintemplate();

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

	User::verifylogintemplate();

	$data = Category::findonecategory($id);
	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories-update.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/categories/:id', function($id){

	User::verifylogintemplate();

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

	User::verifylogintemplate();

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

$app->get('/admin/categories/:idcategory/products', function($id){

	$category_class = new Category();

	User::verifylogintemplate();
	$category = $category_class->findonecategory($id);
	$categoryproductTRUE = $category_class->getrelatedproducts($id, true);
	$categoryproductFALSE = $category_class->getrelatedproducts($id, false);
	
	require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/adm-site/categories-products.php");
	require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->get('/admin/categories/:idcategory/products/:idproduct/add', function($idcategory,$idproduct){

	User::verifylogintemplate();

	Category::addproduct($idcategory,$idproduct);
	header("location: http://localhost/ecommerce/admin/categories/$idcategory/products");
	exit;
});

$app->get('/admin/categories/:idcategory/products/:idproduct/remove', function($idcategory,$idproduct){

	User::verifylogintemplate();

	Category::removeproduct($idproduct);
	header("location: http://localhost/ecommerce/admin/categories/$idcategory/products");
	exit;
});

#products
#lista
$app->get('/admin/products', function(){
    User::verifylogintemplate();

    $data = \PERSONAL\Product::listdata();

    require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/adm-site/products.php");
    require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

#criar
$app->get('/admin/products/create', function(){
    User::verifylogintemplate();

    require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/adm-site/products-create.php");
    require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/products/create', function(){
    User::verifylogintemplate();

	$data = \PERSONAL\Product::listdata();

   	$product = new \PERSONAL\Product();

	if ($_POST['desproduct'] == null || $_POST['vlprice'] == null || $_POST['vlwidth'] == null || $_POST['vlheight'] == null || $_POST['vllength'] == null || $_POST['vlweight'] == null || $_POST['desurl'] == null || $_FILES['imgproduct']['name'] == null) {
			
				$_POST['nofields'] = true;
				require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
				require_once("vendor/PERSONAL/template/adm-site/products-create.php");
				require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
				exit;

	}else{
			try {
				$product->setdata($_POST);
				$product->registerproduct();
		
				header("location: http://localhost/ecommerce/admin/products");
				exit;
			} catch (\Throwable $e) {
				$_POST['statusR'] = "ERROR: ".print_r($e);

				require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
				require_once("vendor/PERSONAL/template/adm-site/products.php");
				require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
				exit;
			} 

	}
});

#editar
$app->get('/admin/products/:id', function($id){
    User::verifylogintemplate();

    $data = \PERSONAL\Product::findoneproduct($id);

    require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
    require_once("vendor/PERSONAL/template/adm-site/products-update.php");
    require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
});

$app->post('/admin/products/:id', function($id){

	User::verifylogintemplate();

	$data = \PERSONAL\Product::listdata();

    $product = new Product();

	try {
        $product->setdata($_POST);
        $product->editproduct($id);

		header("location: http://localhost/ecommerce/admin/products");
		exit;
	} catch (\Throwable $e) {
		$statusE = "ERROR: ".$e;
		require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
		require_once("vendor/PERSONAL/template/adm-site/products.php");
		require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
	}
	
});

#excluir
$app->get('/admin/products/:id/delete', function($id){

	User::verifylogintemplate();

	$product = new Product();

	$data = Product::listdata();
	try {
		$product->setdata($_POST);
		$product->deleteproduct($id);

		header("location: http://localhost/ecommerce/admin/products");
		exit;
	} catch (\Throwable $e) {
		$statusD = "ERROR: ".$e;

		require_once("vendor/PERSONAL/template/adm-site/header-footer/header.php");
		require_once("vendor/PERSONAL/template/adm-site/products.php");
		require_once("vendor/PERSONAL/template/adm-site/header-footer/footer.php");
		exit;
	}

});

$app->run();
