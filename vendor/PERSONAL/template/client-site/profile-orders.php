
<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Minha Conta</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">                
            <div class="col-md-3">
            </div>
            <div class="col-md-9">

                <div class="cart-collaterals">
                    <h2>Meus Pedidos</h2>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <?php
                                if ($order_data ==! null) {
                                    echo '<th>#</th>';
                                    echo '<th>Valor Total</th>';
                                    echo '<th>Status</th>';
                                    echo '<th>Endereço</th>';
                                    echo '<th>&nbsp;</th>';
                                }else{
                                    echo '<h3><b>Nenhum pedido foi encontrado.</b></h3>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>                        
                            <?php

                                foreach ($order_data as $key => $value) {

                                    $addresstext = $order_data[$key]['desaddress'].', '.$order_data[$key]['desdistrict'].', '.$order_data[$key]['descity'].' - '.$order_data[$key]['desstate'];
                                    $addresstext = mb_convert_encoding($addresstext, 'HTML-ENTITIES', 'UTF-8');
                                    echo '<tr>';
                                    echo '<th scope="row">'.$order_data[$key]['idorder'].'</th>';
                                    echo '<td>R$'.$order_data[$key]['vltotal'].'</td>';
                                    echo '<td>'.$order_data[$key]['desstatus'].'</td>';
                                    echo '<td>'.$addresstext.'</td>';
                                    echo '<td><a class="btn btn-success" href="http://localhost/ecommerce/order/'.$order_data[$key]['idorder'].'" role="button">Imprimir Boleto</a></td>';
                                    echo '<td><a class="btn btn-default" href="http://localhost/ecommerce/profile/orders/'.$order_data[$key]['idorder'].'" role="button">Detalhes</a></td>';
                                    echo '<td><a class="btn btn-danger" onclick="javascript: return confirm(`Você realmente deseja cancelar esse pedido?`)" href="http://localhost/ecommerce/profile/orders/'.$order_data[$key]['idorder'].'/delete" role="button">Cancelar Pedido <i class="fa fa-close"></i></a></td>';                                    
                                    echo '</tr>';
                                    }
                            ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>