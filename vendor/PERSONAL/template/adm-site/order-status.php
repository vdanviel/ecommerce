<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Pedido N°<?=$order_data[0]['idorder']?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="http://localhost/ecommerce/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="http://localhost/ecommerce/admin/orders">Pedidos</a></li>
        <li class="active"><a href="http://localhost/ecommerce/admin/orders/<?=$order_data[0]['idorder']?>/edit">Pedido N°<?=$order_data[0]['idorder']?></a></li>
    </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Status do Pedido</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" action="http://localhost/ecommerce/admin/orders/<?=$order_data[0]['idorder']?>/edit" method="post">
                <div class="box-body">

        

                    <div class="form-group">

                    <?php

                        if ($statussuccess ==! '') {

                            echo "<div class='alert alert-success container' style='margin-top: 10px' alert-dismissible>";
                            echo $statussuccess;
                            echo "<button class='close' data-dismiss='alert'>&times;</button>";
                            echo "</div>";

                        }

                        if ($statuserror ==! '') {

                            echo "<div class='alert alert-danger container' style='margin-top: 10px' alert-dismissible>";
                            echo $statuserror;
                            echo "<button class='close' data-dismiss='alert'>&times;</button>";
                            echo "</div>";

                        }

                ?>

                        <label for="desproduct">Status do Pedido</label>
                        <select class="form-control" name="idstatus">
                            <?php
                                for ($i=0; $i < count($order_status); $i++) { 
                                    
                                    echo '<option value="'.$order_status[$i]['idstatus'].'"'; 
                                    if($order_status[$i]['desstatus'] == $order_data[0]['desstatus']){echo "selected";}else{echo "";}
                                    echo ">";
                                    echo $order_status[$i]['desstatus'];
                                    echo '</option>';

                                }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    
    </section>
    <!-- /.content -->

    <div class="clearfix"></div>

</div>
<!-- /.content-wrapper -->