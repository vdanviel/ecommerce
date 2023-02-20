<?php
session_start();
require_once("vendor/autoload.php");

use PERSONAL\Address;
use PERSONAL\Category;
use PERSONAL\Product;
use PERSONAL\Cart;
use PERSONAL\ORDER\Order;
use PERSONAL\ORDER\OrderStatus;
use PERSONAL\TEMPLATE\Visual;
use \PERSONAL\PAYMENT\PIX\Payload;
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

$app->get('/login', function () {
	$user= new User();

	$errorlogin = $user->logingeterror();
	$errorregister = $user->registergeterror();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/login.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->post('/login', function () {

	if ($_POST['email'] == '' || $_POST['password'] == '') {
		User::loginseterror("Falha ao entrar. Preencha todos os campos.");

		header('location: http://localhost/ecommerce/login');
		exit;
	}

	try{
		User::login($_POST['email'], $_POST['password']);

		header('location: http://localhost/ecommerce/');
		exit;
	}catch(Exception $e){
		User::loginseterror('Falha ao entrar. Dados inválidos.');

		header('location: http://localhost/ecommerce/login');
		exit;
	}

});

$app->post('/register', function () {

	if ($_POST['name'] == '' || $_POST['email'] == '' || $_POST['phone'] == '' || $_POST['password'] == '') {
		User::registerseterror("Falha ao registrar. Preencha todos os campos.");
		header('location: http://localhost/ecommerce/login');
		exit;
	}

	try{

		$userlogin= new User();

		$cryptopassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

		$userlogin->setdata(array(
			"inadmin" => 0,
			"desperson" => $_POST['name'],
			"desemail" => $_POST['email'],
			"nrphone" => $_POST['phone'],
			"despassword" =>$cryptopassword
		));

		$userlogin->registeruser();

		User::login($_POST['email'], $_POST['password']);

		header('location: http://localhost/ecommerce/');
		exit;
	}catch(Exception $e){

		User::registerseterror('Falha ao cadastrar. Dados inválidos.');
		header('location: http://localhost/ecommerce/login');
		exit;
	}
});

$app->get('/profile', function(){

	User::verifylogin(false);

	$profilesuccess = User::profilegetsuccess();
	$profileerror = User::profilegeterror();

	$user_session = User::sessionuser();
	$data = User::findoneuser($user_session->getiduser());

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/profile.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->post('/profile', function(){

	if ($_POST['desperson'] == '' || $_POST['desemail'] == '' || $_POST['nrphone'] == '') {
		User::profileseterror("Erro ao atualizar. Preencha todos os campos.");
		header('Location: http://localhost/ecommerce/profile');
		exit;
	}

	$user_session = User::sessionuser();

	User::verifylogin($user_session->getinadmin() == 1 ? true : false);

	$_POST['inadmin'] = $user_session->getinadmin();
	$_POST['despassword'] = $user_session->getdespassword();

	$user_session->setdata($_POST);
	$user_session->edituser($user_session->getiduser());

	$_SESSION[User::SESSION]['deslogin'] = $_POST['desperson'];

	header('location: http://localhost/ecommerce/profile');
	User::profilesetsuccess("Usuário alterado com sucesso.");
	exit;
});

$app->get('/profile/orders', function(){

	$visual = new Visual();
	$access = User::verifylogin(false);

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}

	$order_data = isset($_SESSION['loginsession']) ? (new Order)->listorderuser($_SESSION['loginsession']['iduser']) : null;

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/profile-orders.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");

});

$app->get('/profile/orders/:order', function($idorder){

	$access = User::verifylogin(false);

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}

	$visual = new Visual;
	$order_data = (new Order)->findoneorder($idorder);
	$productstotal = (new Cart)->listcartproductsbyid($order_data[0]['idcart']);

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/profile-orders-detail.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");

});

$app->get('/profile/orders/:order/delete', function($idorder){

	(new Order)->cancelorder($idorder);

	header("location: http://localhost/ecommerce/profile/orders");
	exit;

});

$app->get('/profile/password/:iduser', function($iduser){

	$access = User::verifylogin(false);

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}

	$passwordsuccess = User::passwordgetsuccess();
	$passworderror = User::passwordgeterror();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/profile-change-password.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");

});

$app->post('/profile/password/:iduser', function($iduser){

	$access = User::verifylogin(false);

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}

	if ($_POST['current_pass'] == '' || $_POST['new_pass'] == '' || $_POST['new_pass_confirm'] == '') {
		User::passwordseterror("Erro ao atualizar. Preencha todos os campos.");
		header("Location:  http://localhost/ecommerce/profile/password/$iduser");
		exit;
	}

	if (User::checkpassword($iduser,$_POST['current_pass']) == true) {
		if ($_POST['new_pass'] == $_POST['new_pass_confirm']) {
			
			User::changepassword($_POST['new_pass'],$iduser);

			User::passwordsetsuccess('Senha alterada com sucesso!');
			header("location: http://localhost/ecommerce/profile/password/$iduser");
			exit;

		}else{
			User::passwordseterror('A confirmação da senha não confere com a nova senha.');
			header("location: http://localhost/ecommerce/profile/password/$iduser");
			exit;
		}
	}else {
		User::passwordseterror('A senha atual é inválida.');
		header("location: http://localhost/ecommerce/profile/password/$iduser");
		exit;
	}

});

$app->get('/logout', function () {

	User::logout();

	header('location: http://localhost/ecommerce/');
	exit;
});

$app->get('/forgot', function(){
	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/forgot.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");

});

$app->post('/forgot', function(){
	User::emailrecovery($_POST["email"],true);

	header('location: http://localhost/ecommerce/forgot/sent');
	exit;
});

$app->get('/forgot/sent', function(){

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/forgot-sent.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");

});

$app->get('/forgot/reset', function(){

	$user = User::userdecryptforgot($_GET["code"]);

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/forgot-reset.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");

});

$app->post('/forgot/reset', function(){

	$user = User::userdecryptforgot($_POST["code"]);

	User::setforgotuser($user["idrecovery"]);

	User::changepassword($_POST["password"], $user["iduser"]);

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/forgot-reset-success.php");
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

	$cart_data = $cart->getdata();

	$cart_products = $cart->listcartproducts();

	$error = Cart::geterror();

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/carrinho.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/carrinho/:idproduct/add', function ($id) {

	$product = new Product();

	$product_result = $product->findoneproduct($id);

	$cart = Cart::getcartfromsession();

	$qnt = isset($_GET['qnt']) ? intval($_GET['qnt']) : 1;

	for ($i=0; $i < $qnt ; $i++) { 
		$cart->addproduct($product_result);
	}

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

$app->post('/carrinho/freight', function(){

	$cart = Cart::getcartfromsession();

	$cart->freight($_POST['cep']);
	
	header('location: http://localhost/ecommerce/carrinho');
	exit;
});

$app->get('/checkout', function(){
	$visual = new Visual();
	$address = new Address();
	$cart = Cart::getcartfromsession();

	$access = User::verifylogin(false);

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}elseif(empty($cart)){
		header("location: http://localhost/ecommerce/carrinho");
		exit;
	}

	if (isset($_GET['zipcode']) && !empty($_GET['zipcode'])) {

		$address->setaddressdata($_GET['zipcode']);
		$cart->setdeszipcode($_GET['zipcode']);
		$cart->getcalculatetotal();

		$cart->savecart();
		
		$productstotal_qnt = $cart->listcartproducts();

		$address_data = $address->getcep($_GET['zipcode']);

		$addresserror = Address::geterror();
		require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
		require_once("vendor/PERSONAL/template/client-site/checkout.php");
		require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
	}else {

		$address_data = $address->getcep($_GET['zipcode']);

		$addresserror = Address::geterror();
		require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
		require_once("vendor/PERSONAL/template/client-site/checkout.php");
		require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
	}
});

$app->post('/checkout', function(){

	if ($_POST['zipcode'] == '' || $_POST['desaddress'] == '' || $_POST['desdistrict'] == '' || $_POST['descity'] == ''|| $_POST['desstate'] == '') {
		Address::seterror("Erro ao cadastrar endereço. Preencha todos os campos.");
		header('Location: http://localhost/ecommerce/checkout');
		exit;
	}

	$cart = Cart::getcartfromsession();

	if (!isset($_GET['zipcode'])) {

		$_GET['zipcode'] = $cart->getdeszipcode();

	}

	$access = User::verifylogin(false);
	$address = new Address();
	$user = User::sessionuser();

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}elseif(empty($cart)){
		header("location: http://localhost/ecommerce/carrinho");
		exit;
	}
	
	$_POST['deszipcode'] = $_POST['zipcode'];
	$_POST['idperson'] = $user->getidperson();

	$address->setdata($_POST);
	$address->saveaddress();

	$order = new Order();

	$cart->getcalculatetotal();

	$order->setdata([
		'idcart'=>$cart->getidcart(),
		'idaddress'=>$address->getidaddress(),
		'iduser'=>$user->getiduser(),
		'idstatus'=>OrderStatus::EM_ABERTO,
		'vltotal'=>$cart->getvltotal()
	]);

	$order->saveorder();

	header("location: http://localhost/ecommerce/order/".$order->getidorder()."");
	exit;

});

$app->get('/order/:idorder', function($idorder){

	$access = User::verifylogin(false);

	if ($access === false) {
		header("location: http://localhost/ecommerce/login");
		exit;
	}

	$order = new Order();

	$order_data = $order->findoneorder($idorder);

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/payment.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
});

$app->get('/boleto/:idorder', function($idorder){

	$visual = new Visual();
	$order = new Order();

	$order_data = $order->findoneorder($idorder);

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 10;
	$taxa_boleto = 5.00;
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_cobrado = $order_data[0]['vltotal']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

	$dadosboleto["nosso_numero"] = $order_data[0]['idorder'];  // Nosso numero - REGRA: Máximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $order_data[0]['vltotal'];	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $order_data[0]['desperson'];
	$dadosboleto["endereco1"] = $order_data[0]['desaddress']." ".$order_data[0]['desdistrict'];
	$dadosboleto["endereco2"] = $order_data[0]['descity']." - ".$order_data[0]['desstate']." - ".$order_data[0]['descountry']." CEP: ".$order_data[0]['deszipcode'];

	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Stufeshop E-commerce";
	$dadosboleto["demonstrativo2"] = "Taxa bancária - R$ 5,00";
	$dadosboleto["demonstrativo3"] = "";
	$dadosboleto["instrucoes1"] = "- Cobra multa de 2% após o vencimento";
	$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
	$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: stuffshopecommerce@gmail.com";
	$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto Loja Stufeshop E-commerce";

	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = "";
	$dadosboleto["aceite"] = "";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "";


	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


	// DADOS DA SUA CONTA - ITAÚ
	$dadosboleto["agencia"] = "1690"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "48781";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

	// DADOS PERSONALIZADOS - ITAÚ
	$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

	// SEUS DADOS
	$dadosboleto["identificacao"] = "Stufeshop E-commerce";
	$dadosboleto["cpf_cnpj"] = "24.700.731/0001-08";
	$dadosboleto["endereco"] = "Rua Ademar Saraiva Leão, 234 - Alvarenga, 09853-120";
	$dadosboleto["cidade_uf"] = "São Bernardo do Campo - SP";
	$dadosboleto["cedente"] = "STUFESHOP LTDA - ME";


	$path = './vendor/boletophp/include/';
	require_once($path."funcoes_itau.php"); 
	require_once($path."layout_itau.php");

});

$app->get('/esqueci-a-senha', function () {

	require_once("vendor/PERSONAL/template/client-site/header-footer/header.php");
	require_once("vendor/PERSONAL/template/client-site/r-senha.php");
	require_once("vendor/PERSONAL/template/client-site/header-footer/footer.php");
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
