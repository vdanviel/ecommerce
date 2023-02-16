   
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Carrinho de Compras</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
            
            <?php
            
                if (isset($error) && $error ==! '' && !empty($error)) {
                    
                echo "<div class='alert alert-danger container' style='margin-bottom: 10px' alert-dismissible>";
                echo $error;
                echo "<button class='close' data-dismiss='alert'>&times;</button>";
                echo "</div>";

                }
            
            ?>

                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="#">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <?php
                                                if (empty($cart_products)) {
                                                    echo '<h3><br>Não há produtos no carrinho.<br><h3>';
                                                }else{
                                                    echo '<th class="product-remove">&nbsp;</th>';
                                                    echo '<th class="product-thumbnail">&nbsp;</th>';
                                                    echo '<th class="product-name">Produto</th>';
                                                    echo '<th class="product-price">Preço</th>';
                                                    echo '<th class="product-quantity">Quantidade</th>';
                                                    echo '<th class="product-subtotal">Total</th>';
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            $valortotal = 0;                                            

                                            foreach ($cart_products as $key => $value) {
                                                
                                            echo '<tr class="cart_item">';
                                            echo '<td class="product-remove">';
                                            echo '<a title="Remove this item" class="remove" href="http://localhost/ecommerce/carrinho/'.$cart_products[$key]['idproduct'].'/remove">X</a>';
                                            echo '</td>';

                                            echo '<td class="product-thumbnail">';
                                            echo '<a href="http://localhost/ecommerce/product/'.$cart_products[$key]['desurl'].'"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="'.$visual->levelTheRoute().'./vendor/PERSONAL/template/adm-site/uploaded-files/'.$cart_products[$key]['imgproduct'].'"></a>';
                                            echo '</td>';

                                            echo '<td class="product-name">';
                                            echo '<a href="http://localhost/ecommerce/product/'.$cart_products[$key]['desurl'].'">'.$cart_products[$key]['desproduct'].'</a> ';
                                            echo '</td>';

                                            echo '<td class="product-price">';
                                            echo '<span class="amount">';
                                            echo 'R$';
                                            echo $visual->formatprice($cart_products[$key]["vlprice"]);
                                            echo '</span>';
                                            echo '</td>';

                                            echo '<td class="product-quantity">';
                                            echo '<div class="quantity buttons_added">';
                                            echo '<input type="button" class="minus" value="-" onclick="window.location.href=';
                                            echo "'http://localhost/ecommerce/carrinho/".$cart_products[$key]['idproduct']."";
                                            echo "/remove'";
                                            echo '">';
                                            echo '<input type="text" size="1" class="input-text qty text" value="'.$cart_products[$key]['nrqtd'].'" min="0" step="1">';
                                            echo '<input type="button" class="plus" value="+" onclick="window.location.href=';
                                            echo "'http://localhost/ecommerce/carrinho/".$cart_products[$key]['idproduct']."";
                                            echo "/add'";
                                            echo '">';
                                            echo '</div>';
                                            echo '</td>';

                                            echo '<td class="product-subtotal">';
                                            echo '<span class="amount">';
                                            echo 'R$';
                                            echo $visual->formatprice($cart_products[$key]["vltotal"]);
                                            echo '</span>';
                                            echo '</td>';
                                            echo '</tr>';

                                            }
                                        ?>

                                    </tbody>
                                </table>
                            </form>

                            <div class="cart-collaterals">

                                <div class="cross-sells">

                                    <h2>Cálculo de Frete</h2>
                                    <form action="http://localhost/ecommerce/carrinho/freight" method="post">
                                        <div class="coupon">
                                            <label for="cep">CEP:</label>
                                            <input type="text" placeholder="00000-000" value="" id="cep" class="input-text" name="cep">
                                            <input type="submit" value="CALCULAR" class="button">
                                        </div>
                                    </form>
                                </div>


                                <div class="cart_totals ">
                                    <h2>Resumo da Compra</h2>

                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span class="amount">R$<?=$visual->formatprice($cart_data['vlsubtotal'])?></span></td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Frete</th>
                                                <td><?php if(!empty($cart_products)){ echo $cart_data['vlfreight'] !== '' ? $visual->formatprice($cart_data['vlfreight']) : ""; }else{echo "R$0";} ?><br><small><?php if(!empty($cart_products)){$cart_data['nrdays'] > 0 ? "Prazo de: ". $cart_data['nrdays'] ." dias.": ""; }else{echo "";}?></small></td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td><strong><span class="amount"><?= !empty($cart_products) ? $visual->formatprice($cart_data['vltotal']) : "R$0"?></span></strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="pull-right">
                                <form action="http://localhost/ecommerce/checkout" method="get">
                                    <input type="hidden" name="zipcode" value="<?=isset($cart_data['deszipcode']) ? $cart_data['deszipcode'] : ""?>">
                                    <input type="submit" value="Finalizar Compra" name="proceed" class="checkout-button button alt wc-forward">
                                </form>
                            </div>

                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
