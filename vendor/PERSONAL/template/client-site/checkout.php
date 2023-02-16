
<div class="product-big-title-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-bit-title text-center">
					<h2>Pagamento</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="single-product-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-content-right">
					<form action="http://localhost/ecommerce/checkout" class="checkout" method="post" name="checkout">
						<div id="customer_details" class="col2-set">
							<div class="row">
								<div class="col-md-12">

									<?php
            
										if ($addresserror ==! '') {
											
											echo "<div class='alert alert-danger container' style='margin-bottom: 10px' alert-dismissible>";
											echo $addresserror;
											echo "<button class='close' data-dismiss='alert'>&times;</button>";
											echo "</div>";

										}
		
									?>

									<div class="woocommerce-billing-fields">
										<h3>Endereço de entrega</h3>
										<p id="billing_address_0_field" class="form-row form-row-wide address-field validate-required">
											<label class="" for="billing_address_0">Cep
											</label>
                                            <input type="number" value="<?=isset($_GET['zipcode']) ? $_GET['zipcode'] : ""?>" placeholder="00000-000" id="billing_address_0" name="zipcode" style="margin-bottom:10px ;"><br>
                                            <input type="submit" value="Atualizar CEP" id="place_order" class="button alt" formaction="http://localhost/ecommerce/checkout" formmethod="get">
										</p>
										<p id="billing_address_1_field" class="form-row form-row-wide address-field validate-required">
											<label class="" for="billing_address_1">Endereço
											</label>
											<input type="text" value="<?=$address_data ==! null ? $address_data['logradouro'].", ".$address_data['gia'] : ""?>" placeholder="Logradouro, número e bairro" id="billing_address_1" name="desaddress" class="input-text ">
										</p>
										<p id="billing_address_2_field" class="form-row form-row-wide address-field">
											<label class="" for="billing_address_2">Complemento
											</label>
											<input type="text" value="" placeholder="Complemento (opcional)" id="billing_address_2" name="descomplement" class="input-text ">
                                        </p>
                                        <p id="billing_district_field" class="form-row form-row-wide address-field validate-required" data-o_class="form-row form-row-wide address-field validate-required">
											<label class="" for="billing_district">Bairro
											</label>
											<input type="text" value="<?=$address_data ==! null ? $address_data['bairro'] : ""?>" placeholder="Cidade" id="billing_district" name="desdistrict" class="input-text ">
										</p>
										<p id="billing_city_field" class="form-row form-row-wide address-field validate-required" data-o_class="form-row form-row-wide address-field validate-required">
											<label class="" for="billing_city">Cidade
											</label>
											<input type="text" value="<?=$address_data ==! null ? $address_data['localidade'] : ""?>" placeholder="Cidade" id="billing_city" name="descity" class="input-text ">
										</p>
										<p id="billing_state_field" class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
											<label class="" for="billing_state">Estado</label>
											<input type="text" id="billing_state" name="desstate" placeholder="Estado" value="<?=$address_data ==! null ? $address_data['uf'] : ""?>" >											
										<p id="billing_state_field" class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">

											<input type="hidden" id="billing_state" name="descountry" placeholder="País" value="Brasil" class="input-text ">

										</p>
										<div class="clear"></div>
										<h3 id="order_review_heading" style="margin-top:30px;">Detalhes do Pedido</h3>
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
															<?php if(count($productstotal_qnt) > 1){echo $productstotal_qnt[0]['desproduct'].", ".$productstotal_qnt[1]['desproduct']." [...]";}else{echo $productstotal_qnt[0]['desproduct'];}?> <strong class="product-quantity">x <?=intval(count($productstotal_qnt))?></strong> 
														</td>
														<td class="product-total">
															<span class="amount"><?=$visual->formatprice($cart->getvlsubtotal())?></span>
														</td>
                                                    </tr>
                                                    
												</tbody>
												<tfoot>
													<tr class="cart-subtotal">
														<th>Total</th>
														<td><span class="amount"><?=$visual->formatprice($cart->getvlsubtotal())?></span>
														</td>
													</tr>
													<tr class="shipping">
														<th>Frete</th>
														<td>
															<?=$visual->formatprice($cart->getvlfreight())?>
															<input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
														</td>
													</tr>
													<tr class="order-total">
														<th>Total do Pedido</th>
														<td><strong><span class="amount"><?=$visual->formatprice($cart->getvltotal())?></span></strong> </td>
													</tr>
												</tfoot>
											</table>
											<div id="payment">
												<div class="form-row place-order">
													<input type="submit" data-value="Place order" value="Continuar" id="place_order" name="woocommerce_checkout_place_order" class="button alt">
												</div>
												<div class="clear"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>