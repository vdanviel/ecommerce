<style>
@media print {
    .header-area,
    .site-branding-area,
    .sticky-wrapper,
    .footer-top-area,
    .footer-bottom-area,
    .single-product-area .col-md-3,
    .button.alt,
    .product-big-title-area {
        display:none!important;
    }
    .single-product-area .col-md-9 {
        width: 100%!important;
    }
}
</style>

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
                
                <h3 id="order_review_heading" style="margin-top:30px;">Detalhes do Pedido N°<?=$order_data[0]['idorder']?></h3>
                <div id="order_review" style="position: relative;">
                    <table class="shop_table">
                        <thead>
                            <tr>
                                <th class="product-name">Produto</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="cart_item">
                                <td class="product-name">
                                <?php if(count($productstotal) > 1){echo $productstotal[0]['desproduct'].", ".$productstotal[1]['desproduct']." [...]";}else{echo $productstotal[0]['desproduct'];}?><strong class="product-quantity">x<?=count($productstotal)?></strong> 
                                </td>
                                <td class="product-total">
                                    <span class="amount">R$<?=$visual->formatprice(floatval($order_data[0]['vltotal']) - floatval($order_data[0]['vlfreight']))?></span>
                                </td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th>Subtotal</th>
                                <td><span class="amount">R$<?=$visual->formatprice(floatval($order_data[0]['vltotal']) - floatval($order_data[0]['vlfreight']))?></span>
                                </td>
                            </tr>
                            <tr class="shipping">
                                <th>Frete</th>
                                <td>
                                    R$<?=$visual->formatprice($order_data[0]['vlfreight'])?>
                                    <input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Total do Pedido</th>
                                <td><strong><span class="amount">R$<?=$visual->formatprice($order_data[0]['vltotal'])?></span></strong> </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment">
                        <div class="form-row place-order">
                            <input type="submit" value="Imprimir" class="button alt" onclick="window.print()">
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>