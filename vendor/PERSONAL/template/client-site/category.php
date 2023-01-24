<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2><?=$category[0]['descategory']?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">

        <?php

            foreach ($productscategory as $key => $value) {
                echo '<div class="col-md-3 col-sm-6">';
                echo '<div class="single-shop-product">';
                echo '<div class="product-upper">';
                echo '<img ';
                echo "src=";
                echo $visual->levelTheRoute().'./vendor/PERSONAL/template/adm-site/uploaded-files/';
                echo $productscategory[$key]['imgproduct']." alt='product-image' ";
                echo ">";
                echo '<div class="product-info">';
                echo '<h2><a href="http://localhost/ecommerce/product/'.$productscategory[$key]['desurl'].'">'.$productscategory[$key]['desproduct'].'</a></h2>';
                echo '<div class="product-carousel-price">';
                echo '<ins>R$';
                echo $visual->formatprice($productscategory[$key]['vlprice']);
                echo '</ins>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
               
                echo '<div class="product-option-shop">';
                echo '<a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Adicionar ao Carrinho</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>

        

        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="product-pagination text-center">
                    <nav>
                        <ul class="pagination">
                        <li>
                            <a href="http://localhost/ecommerce/category/5/<?= $page == 1 ? $page = 1 : $page - 1?>" id="previous-page" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                            </a>
                        </li>

                        <?php
                            for ($i = 1; $i < $pages + 1; $i++) { 
                                echo '<li><a href="http://localhost/ecommerce/category/'.$id.'/'.$i.'">'.$i.'</a></li>';
                            }
                        ?>
                       
                        <li>
                            <a <?= intval($page) == $pages ? 'onmouseover="button_next_off()' : ''?> href="http://localhost/ecommerce/category/<?=$id?>/<?=$page+1?>" id="next-page" aria-label="Next">
                            <span aria-hidden="true">»</span>
                            </a>
                        </li>
                        </ul>
                    </nav>                        
                </div>
            </div>
        </div>
    </div>
</div>