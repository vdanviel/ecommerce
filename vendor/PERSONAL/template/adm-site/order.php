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
        <li class="active"><a href="http://localhost/ecommerce/admin/orders/<?=$order_data[0]['idorder']?>/details">Pedido N°<?=$order_data[0]['idorder']?></a></li>
    </ol>
    </section>

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
            <h2 class="page-header">
                <img height="40px" src="<?php $visual->levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/img/general/logo-stufeshop-blue.png" alt="Logo">
                <small class="pull-right"><?=date('d/m/Y')?></small>
            </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
            De
            <address>
                <strong>StufeShop</strong><br>
                Rua Ademar Saraiva Leão, 234 - Alvarenga<br>
                São Bernardo do Campo - SP<br>
                Telefone: (11) 3171-3080<br>
                E-mail: stuffshopecommerce@gmail.com
            </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            Para
            <address>
                <strong><?=$order_data[0]['deslogin']?></strong><br>
                <?=$order_data[0]['desaddress']?>, 
                <?=$order_data[0]['descity']?> - <?=$order_data[0]['desstate']?><br>
                Complemento: <?=isset($order_data[0]['descomplement']) ? $order_data[0]['descomplement'] : "(Não há complemento)"?><br>
                Telefone: <?=$order_data[0]['nrphone']?><br>
                E-mail: <?=$order_data[0]['desemail']?>
            </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            <b>Pedido #<?=$order_data[0]['idorder']?></b><br>
            <br>
            <b>Emitido em:</b> <?php $date = date_create($order_data[0]['dtregister']); echo date_format($date, 'd/m/Y H:i');?><br>
            <b>Pago em:</b> <?=date_format($date, 'd/m/Y H:i')?>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Qtd</th>
                    <th>Produto</th>
                    <th>Código #</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                    <?php

                        $url = "'http://localhost/ecommerce/admin/orders/{$order_data[0]['idorder']}/edit";

                        foreach ($order_cart as $key => $value) {
                            
                            echo "<tr>";
                            echo "<td>".$order_cart[$key]['nrqtd']."</td>";
                            echo "<td>".$order_cart[$key]['desproduct']."</td>";
                            echo "<td>".$order_cart[$key]['idproduct']."</td>";
                            echo "<td>".$order_cart[$key]['vltotal']."</td>";
                            echo "</tr>"; 
                            
                        }
                    ?>
                </tbody>
            </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

                <p class="lead">Forma de Pagamento</p>
                
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:180px;">Método de Pagamento:</th>
                        <td>Boleto</td>
                    </tr>
                    <tr>
                        <th>Parcelas:</th>
                        <td>1x</td>
                    </tr>
                    <!--
                    <tr>
                        <th>Valor da Parcela:</th>
                        <td>R$100,00</td>
                    </tr>
                    -->
                    </tbody>
                </table>

            </div>
            <!-- /.col -->
            <div class="col-xs-6">
            <p class="lead">Resumo do Pedido</p>
    
            <div class="table-responsive">
                <table class="table">
                <tbody><tr>
                    <th style="width:50%">Subtotal:</th>
                    <td>R$<?=$visual->formatprice($order_data[0]['vltotal'] - $order_data[0]['vlfreight'])?></td>
                </tr>
                <tr>
                    <th>Frete:</th>
                    <td>R$<?=$visual->formatprice($order_data[0]['vlfreight'])?></td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td><?=$visual->formatprice($order_data[0]['vltotal'])?></td>
                </tr>
                </tbody></table>
            </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
            <a href='http://localhost/ecommerce/admin/orders/<?=$order_data[0]['idorder']?>/edit' class='btn btn-primary'><i class='fa fa-pencil'></i>&nbsp;&nbsp;Editar Status de Pedido</a>

            <a href='http://localhost/ecommerce/boleto/<?=$order_data[0]['idorder']?>' class='btn btn-primary'><i class='fa fa-barcode'></i>&nbsp;&nbsp;Gerar Boleto</a>

                
                <button type="button" onclick="window.print()" class="btn btn-primary pull-right" style="margin-right: 5px;">
                    <i class="fa fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>

</div>
<!-- /.content-wrapper -->