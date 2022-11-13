<?php require_once('./vendor/autoload.php'); use \PERSONAL\Category;?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Categorias
  </h1>
  <?php
    if (isset($statusR)) {
      if ($statusR == "SUCCESS") {
        echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Categoria cadastrada com sucesso.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }else{
        echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Falha ao cadastrar categoria.<br>".$statusR;
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }
    }
    
    if (isset($statusE)) {
      if ($statusE == "SUCCESS") {
        echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Categoria editada com sucesso.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }else{
        echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Falha ao editar categoria.<br>".$statusE;
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }
    }

    if (isset($statusD)) {
      if ($statusD == "SUCCESS") {
        echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Categoria excluída com sucesso.";
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }else{
        echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
        echo "Erro ao excluir categoria.<br>".$statusD;
        echo "<button class='close' data-dismiss='alert'>&times;</button>";
        echo "</div>";
      }
    }
  ?>
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
              <a href="http://localhost/ecommerce/admin/categories/create" class="btn btn-primary">Cadastrar Categoria</a>
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
                    $data = Category::listdata();

                    foreach($data as $key => $value){
                      echo "<tr>";
                      echo "<td>".$data[$key]["idcategory"]."</td>";
                      echo "<td>".$data[$key]["descategory"]."</td>";
                      echo "<td><a href='http://localhost/ecommerce/admin/categories/{$data[$key]['idcategory']}' class='btn btn-white'><i class='fa fa-pencil'></i></a></td>";
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