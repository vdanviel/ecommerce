<?php require_once("vendor/autoload.php"); use \PERSONAL\TEMPLATE\Visual;?>
<!DOCTYPE html>
<html style="display: flex; height: 100%; justify-content: center;">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/plugins/iCheck/square/blue.css">
</head>
<body style="display: flex; height: 100%; align-items: center; background-color: #ecf0f5;">
<div class="col-xxl-4" style="color:#ecf0f5; border-radius:15px; padding:20px; display: flex; align-items: center; flex-direction: column; background-color: #3c8dbc;">
    <h1>Tem certeza que deseja excluir o usuário?</h1>
    <p>Os dados serão perdidos e não poderão ser recuperados.</p>
    <div class="container-md">
      <form class="row g-3" method="post">
        <div class="col-auto">
          <button type="submit" name="confirm" class="btn btn-danger">Excluir Usuário</button>
          <button type="submit" name="cancel" style="color: black;" class="btn btn-secondary">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
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