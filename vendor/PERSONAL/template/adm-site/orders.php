<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Pedidos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="/admin/orders">Pedidos</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Cliente</th>
                    <th>Valor Total</th>
                    <th>Valor do Frete</th>
                    <th>Status</th>
                    <th style="width: 220px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>

                <?php             
                    

                    if ($orders_data == NULL) {
                      
                      echo '<tr>';
                      echo '<td colspan="6">Nenhum pedido foi encontrado.</td>';
                      echo '</tr>';

                    }else{

                      foreach($orders_data as $key => $value){

                        echo "<tr>";
                        echo "<td>".$orders_data[$key]["idorder"]."</td>";
                        echo "<td>".$orders_data[$key]["deslogin"]."</td>";
                        echo "<td>".$orders_data[$key]["vltotal"]."</td>";
                        echo "<td>".$orders_data[$key]["vlfreight"]."</td>";
                        echo "<td>";
                        echo $orders_data[$key]["desstatus"] == "Cancelado" ? "<b style='color:red;'>".$orders_data[$key]['desstatus']."</b>" : $orders_data[$key]["desstatus"];
                        echo "</td>";
                        echo '<td><a href="http://localhost/ecommerce/admin/orders/'.$orders_data[$key]['idorder'].'/details" class="btn btn-default btn-xs"><i class="fa fa-search"></i> Detalhes</a></td>';
                        echo "<td><a href='http://localhost/ecommerce/admin/orders/{$orders_data[$key]['idorder']}/edit' class='btn btn-white'><i class='fa fa-pencil'></i></a></td>";
                        echo "</tr>";
                      }

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