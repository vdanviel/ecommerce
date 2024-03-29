<?php

use PERSONAL\TEMPLATE\Visual;
?>
<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2><?=$productdetail[0]['desproduct']?></h2>
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
                    <div class="product-breadcroumb">
                        <a href="http://localhost/ecommerce">Home</a>
                        <a href="http://localhost/ecommerce/product/<?=$productdetail[0]['desurl']?>"><?=$productdetail[0]['desproduct']?></a>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="product-images">
                                <div class="product-main-img">
                                    <img src='<?=Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/uploaded-files/<?=$productdetail[0]['imgproduct']?>'>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="product-inner">
                                <h2 class="product-name"><?=$productdetail[0]['desproduct']?></h2>
                                <div class="product-inner-price">
                                    <ins><?=Visual::formatprice($productdetail[0]['vlprice'])?></ins>
                                </div>    
                                
                                <form action="http://localhost/ecommerce/carrinho/<?=$productdetail[0]['idproduct']?>/add" class="cart">
                                    <div class="quantity">
                                        <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="qnt" min="1" step="1">
                                    </div>
                                    <button class="add_to_cart_button" type="submit">Adicionar ao Carrinho</button>
                                </form>
                                
                                <div class="product-inner-category">
                                    <p>Categorias: <a href="http://localhost/ecommerce/category/<?=$productdetail[0]['idcategory']?>/1"><?=$productdetail[0]['descategory']?></a>
                                </div> 
                                
                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Descrição</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <h2>Descrição do Produto</h2>  
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tristique, diam in consequat iaculis, est purus iaculis mauris, imperdiet facilisis ante ligula at nulla. Quisque volutpat nulla risus, id maximus ex aliquet ut. Suspendisse potenti. Nulla varius lectus id turpis dignissim porta. Quisque magna arcu, blandit quis felis vehicula, feugiat gravida diam. Nullam nec turpis ligula. Aliquam quis blandit elit, ac sodales nisl. Aliquam eget dolor eget elit malesuada aliquet. In varius lorem lorem, semper bibendum lectus lobortis ac.</p>

                                            <p>Mauris placerat vitae lorem gravida viverra. Mauris in fringilla ex. Nulla facilisi. Etiam scelerisque tincidunt quam facilisis lobortis. In malesuada pulvinar neque a consectetur. Nunc aliquam gravida purus, non malesuada sem accumsan in. Morbi vel sodales libero.</p>
                                        </div>
                    
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>                    
            </div>
        </div>
    </div>
</div>