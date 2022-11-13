<?php require_once("./vendor/autoload.php"); use \PERSONAL\TEMPLATE\Visual;?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Reset Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/css/AdminLTE.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style="background: #14427a" class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
      <a href="http://localhost/ecommerce/admin"><img height="40px" src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/img/general/logo-stufeshop.png" alt="logo"></a>
  </div>
  
   <div style="color: white" class="help-block text-center">
     Olá <?=$user["desperson"]?>, digite uma nova senha:
    </div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">

    <!-- lockscreen credentials (contains the form) -->
    <form method="post">
      <input type="hidden" name="code" value="<?=$_GET["code"]?>">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Digite a nova senha" name="password">
        <div class="input-group-btn">
          <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  
  <div style="color: black" class="lockscreen-footer text-center">
    Copyright &copy; 2014-2016 <b><a href="http://almsaeedstudio.com" class="text-black">Almsaeed Studio</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery 2.2.3 -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
