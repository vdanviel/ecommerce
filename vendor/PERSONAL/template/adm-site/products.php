<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
    <?php
    if (isset($statusR)) {
        if ($statusR == "SUCCESS") {
            echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
            echo "Produto cadastrado com sucesso.";
            echo "<button class='close' data-dismiss='alert'>&times;</button>";
            echo "</div>";
        }else{
            echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
            echo $statusR;
            //echo "Falha ao cadastrar produto.";
            echo "<button class='close' data-dismiss='alert'>&times;</button>";
            echo "</div>";
        }
    }

    if (isset($statusE)) {
        if ($statusE == "SUCCESS") {
            echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
            echo "Produto editado com sucesso.";
            echo "<button class='close' data-dismiss='alert'>&times;</button>";
            echo "</div>";
        }else{
            echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
            echo "Falha ao editar produto.";
            echo "<button class='close' data-dismiss='alert'>&times;</button>";
            echo "</div>";
        }
    }

    if (isset($statusD)) {
        if ($statusD == "SUCCESS") {
            echo "<div class='alert alert-success container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
            echo "Produto excluído com sucesso.";
            echo "<button class='close' data-dismiss='alert'>&times;</button>";
            echo "</div>";
        }else{
            echo "<div class='alert alert-danger container' style='margin: 15px; margin-bottom:0; margin-left:0;' alert-dismissible>";
            echo "Erro ao excluir produto.";
            echo "<button class='close' data-dismiss='alert'>&times;</button>";
            echo "</div>";
        }
    }
    ?>
  <ol class="breadcrumb">
    <li><a href="http://localhost/ecommerce/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="http://localhost/ecommerce/admin/products">Produtos</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="http://localhost/ecommerce/admin/products/create" class="btn btn-primary">Cadastrar Produto</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th style="width: 10px">#</th>
                      <th>Nome da Produto</th>
                      <th>Preço</th>
                      <th>Largura</th>
                      <th>Altura</th>
                      <th>Comprimento</th>
                      <th>Peso</th>
                      <th style="width:350px ;">&nbsp;</th>
                  </tr>
                </thead>

                <tbody>
                <?php
                foreach($data as $key => $value){
                    echo "<tr>";
                    echo "<td>".$data[$key]['idproduct']."</td>";
                    echo "<td>".$data[$key]['desproduct']."</td>";
                    echo "<td>".$data[$key]['vlprice']."</td>";
                    echo "<td>".$data[$key]['vlwidth']."</td>";
                    echo "<td>".$data[$key]['vlheight']."</td>";
                    echo "<td>".$data[$key]['vllength']."</td>";
                    echo "<td>".$data[$key]['vlweight']."</td>";
                    echo "<td><a href='/admin/products/".$data[$key]['idproduct']."' class='btn btn-white'><i class='fa fa-pencil'><i></a></td>";
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