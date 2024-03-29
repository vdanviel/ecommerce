<?php require_once("vendor/autoload.php"); use \PERSONAL\TEMPLATE\Visual;?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <link rel="icon" type="image/x-icon" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/img/general/icon-stufeshopcopytine.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/css/skins/skin-blue.css">
    <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style="background: #14427a" class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <img height="40px" src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/img/general/logo-stufeshop.png" alt="logo">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div><p><?if(isset($_SESSION["denied"])) echo $_SESSION["denied"]?></p></div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button style="background: #184f92;  " type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a style="color: #185093" href="http://localhost/ecommerce/admin/forgot">I forgot my password</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
