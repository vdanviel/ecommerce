<?php require_once("vendor/autoload.php");

use PERSONAL\Category;
use PERSONAL\Cart;
use \PERSONAL\TEMPLATE\Visual;
use \PERSONAL\Product;
use \PERSONAL\USER\User as User;

$category_header = Category::listdata();
$user_session = User::sessionuser() !== null ? User::sessionuser() : "";

$cart_session = Cart::getcartfromsession() !== NULL ? Cart::getcartfromsession() : NULL;
$cart_session = $cart_session->listcartproductstotal();


?>
<!DOCTYPE html>

<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StufeShop</title>

    <link rel="icon" type="image/x-icon" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/img/general/icon-stufeshopcopytine.ico">

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/client-site/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/client-site/css/font-awesome.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/client-site/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/client-site/css/style.css">
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/client-site/css/responsive.css">
    
  </head>
  <body>
   
    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
                            <?= User::verifylogin(false) == true ? '<li><a href="http://localhost/ecommerce/profile"><i class="fa fa-user"></i>'.ucwords(utf8_decode($user_session->getdeslogin())).'</a></li>' : '<li><a href="http://localhost/ecommerce/login"><i class="fa fa-lock"></i> Login</a></li>'?>     
                            <li><a href="#"><i class="fa fa-heart"></i> Lista de Desejos</a></li>
                            <li><a href="http://localhost/ecommerce/carrinho"><i class="fa fa-shopping-cart"></i> Meu Carrinho</a></li>
                            <?= User::verifylogin(false) == true ? '<li><a href="http://localhost/ecommerce/logout" onclick="return confirm(`Deseja realmente sair?`)"><i class="fa fa-close"></i> Sair</a></li>' : ''?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End header area -->
    
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="http://localhost/ecommerce/"><img src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/client-site/img/logo-stufeshop.png"></a></h1>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="shopping-item">
                        <a href="http://localhost/ecommerce/carrinho">Carrinho  <span class="cart-amunt"><?= $cart_session ==! NULL ? Visual::formatprice("- R$".$cart_session["vlprice"]) : "- R$0"?></span> <i class="fa fa-shopping-cart"></i> <span class="product-count"><?= $cart_session ==! NULL ? $cart_session['totalproducts'] : "0"?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->
    
    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="http://localhost/ecommerce">Home</a></li>
                        <li><a href="http://localhost/ecommerce/lista-produtos/1">Produtos</a></li>
                        <li class="dropdown dropdown-small categories">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Categorias</a>
                            <ul class="dropdown-menu">
                                <?php
                                    foreach($category_header as $key => $value){
                                        echo "<li> <a href='http://localhost/ecommerce/category/".$category_header[$key]['idcategory']."/1'>";
                                        echo $category_header[$key]['descategory'].'</a>';
                                        echo "</li>";
                                    }
                                ?>
                            </ul>
                        </li>
                        <li><a href="http://localhost/ecommerce/carrinho">Carrinho</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End mainmenu area -->
  <hr>