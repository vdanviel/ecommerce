   
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Lista de Produtos</h2>
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
                        foreach ($product as $key => $value){
                            echo '<div class="col-md-3 col-sm-6">';
                            echo '<div class="single-shop-product">';
                            echo '<div  class="product-upper">';
                            echo '<img ';
                            echo 'src="';
                            echo $visual->levelTheRoute();
                            echo './vendor/PERSONAL/template/adm-site/uploaded-files/'.$product[$key]['imgproduct'].'"';
                            echo ' alt="product-image">';
                            echo '<div class="product-info">';
                            echo '<h2><a href="http://localhost/ecommerce/product/'.$product[$key]['desurl'].'">'.$product[$key]["desproduct"].'</a></h2>';
                            echo '<div class="product-carousel-price">';
                            echo '<ins>R$';
                            echo $visual->formatprice($product[$key]['vlprice']);
                            echo '</ins>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="product-option-shop">';
                            echo '<a class="add_to_cart_button" data-quantity="1" data-product_sku="'.$product[$key]['idproduct'].'" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>';
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
                              <a href="http://localhost/ecommerce/lista-produtos/<?php echo $previous <= 0 ? $previous = 1 : $previous ?>" id="previous-page" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <?php
                                for ($i = 1; $i < $pages + 1; $i++) { 
                                    echo '<li><a href="http://localhost/ecommerce/lista-produtos/'.$i.'">'.$i.'</a></li>';
                                }
                            ?>
                            <li>
                              <a <?= intval($page) == $pages ? 'onmouseover="button_next_off()' : ''?> href="http://localhost/ecommerce/lista-produtos/<?=$next?>" id="next-page" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>                        
                    </div>
                </div>
            </div>
        </div>
    </div>