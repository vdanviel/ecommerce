   
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
                        foreach ($data as $key => $value){
                            echo '<div class="col-md-3 col-sm-6">';
                            echo '<div class="single-shop-product">';
                            echo '<div class="product-upper">';
                            echo '<img src="./vendor/PERSONAL/template/client-site/img/product-2.jpg" alt="">';
                            echo '</div>';
                            echo '<h2><a href=""><?=$data['.$key.']["desproduct"]?></a></h2>';
                            echo '<div class="product-carousel-price">';
                            echo '<ins>$899.00</ins> <del>$999.00</del>';
                            echo '</div>';
                            echo '<div class="product-option-shop">';
                            echo '<a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>';
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
                              <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                              <a href="#" aria-label="Next">
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