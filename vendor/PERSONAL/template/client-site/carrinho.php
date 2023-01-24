   
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
                
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="#">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">&nbsp;</th>
                                            <th class="product-thumbnail">&nbsp;</th>
                                            <th class="product-name">Produto</th>
                                            <th class="product-price">Preço</th>
                                            <th class="product-quantity">Quantidade</th>
                                            <th class="product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

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
                                            echo '<span class="amount">R$'.$visual->formatprice($cart_products[$key]['vlprice']).'</span> ';
                                            echo '</td>';

                                            echo '<td class="product-quantity">';
                                            echo '<div class="quantity buttons_added">';
                                            echo '<input type="button" class="minus" value="-" onclick="window.location.href=';
                                            echo "'http://localhost/ecommerce/carrinho/".$cart_products[$key]['idproduct']."";
                                            echo "/remove'";
                                            echo '">';
                                            echo '<input type="number" inputmode="numeric" size="4" class="input-text qty text" title="Qty" value="'.$cart_products[$key]['nrqtd'].'" min="0" step="1">';
                                            echo '<input type="button" class="plus" value="+" onclick="window.location.href=';
                                            echo "'http://localhost/ecommerce/carrinho/".$cart_products[$key]['idproduct']."";
                                            echo "/add'";
                                            echo '">';
                                            echo '</div>';
                                            echo '</td>';

                                            echo '<td class="product-subtotal">';
                                            echo '<span class="amount">R$'.$visual->formatprice($cart_products[$key]['vltotal']).'</span> ';
                                            echo '</td>';
                                            echo '</tr>';
                                        
                                            }
                                        ?>

                                        <tr>
                                            <td class="actions" colspan="6">
                                                <div class="coupon">
                                                <label for="coupon_code">Cupom:</label>
                                                <input type="text" placeholder="Coupon code" value="" id="coupon_code" class="input-text" name="coupon_code">
                                                <input type="submit" value="Aplicar" name="apply_coupon" class="button">
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </form>

                            <div class="cart-collaterals">

                                <div class="cross-sells">

                                    <h2>Cálculo de Frete</h2>
                                    <form>
                                        <div class="coupon">
                                            <label for="cep">CEP:</label>
                                            <input type="text" placeholder="00000-000" value="" id="cep" class="input-text" name="cep">
                                            <input type="submit" value="CÁLCULAR" class="button">
                                        </div>
                                    </form>

                                </div>


                                <div class="cart_totals ">
                                    <h2>Resumo da Compra</h2>

                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span class="amount">R$15,00</span></td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Frete</th>
                                                <td>R$0,00</td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td><strong><span class="amount">R$15,00</span></strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="pull-right">
                                <input type="submit" value="Finalizar Compra" name="proceed" class="checkout-button button alt wc-forward">
                            </div>

                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
