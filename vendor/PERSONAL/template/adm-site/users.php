<?php require_once('./vendor/autoload.php'); use \PERSONAL\USER\User;?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edite um Usuário
  </h1>
  <?php
    if (isset($statusR)) {
      if ($statusR == "SUCCESS") {
        echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Usuário cadastrado com sucesso.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }else{
        echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Falha ao cadastrar usuário.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }
    }
    
    if (isset($statusE)) {
      if ($statusE == "SUCCESS") {
        echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Usuário editado com sucesso.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }else{
        echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Falha ao editar usuário.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }
    }

    if (isset($statusD)) {
      if ($statusD == "SUCCESS") {
        echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Usuário excluído com sucesso.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }else{
        echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Erro ao excluir usuário.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }
    }
  ?>
  <ol class="breadcrumb">
    <li><a href="http://localhost/ecommerce/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href=http://localhost/ecommerce/admin/users">Usuários</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="http://localhost/ecommerce/admin/users/create" class="btn btn-primary">Cadastrar Usuário</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th style="width: 300px;">Email</th>
                    <th>Telefone</th>
                    <th style="width: 10px">Admin</th>
                    <th style="width:350px ;">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php             
                    $data = User::listdata();

                    foreach($data as $key => $value){

                      $data[$key]["inadmin"] === 1 ? $inadmindisplay = "checked" : $inadmindisplay = "";
                      $data[$key]["inadmin"] === 1 ? $inadminid = "flexCheckCheckedDisabled" : $inadminid = "flexCheckDisabled";

                      echo "<tr>";
                      echo "<td>".$data[$key]["iduser"]."</td>";
                      echo "<td>".$data[$key]["desperson"]."</td>";
                      echo "<td>".$data[$key]["desemail"]."</td>";
                      echo "<td>".$data[$key]["nrphone"]."</td>";
                      echo "<td><input class='form-check-input' type='checkbox' value='' id='$inadminid' $inadmindisplay disabled></td>";
                      echo "<td><a href='http://localhost/ecommerce/admin/users/{$data[$key]['iduser']}' class='btn btn-white'><i class='fa fa-pencil'></i></a></td>";
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            </div>
                      
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->