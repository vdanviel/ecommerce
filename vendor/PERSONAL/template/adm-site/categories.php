<?php require_once('./vendor/autoload.php'); use \PERSONAL\USER\User;?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Categorias
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="/admin/categories">Categorias</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="/admin/categories/create" class="btn btn-success">Cadastrar Categoria</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome da Categoria</th>
                    <th style="width: 140px">&nbsp;</th>
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