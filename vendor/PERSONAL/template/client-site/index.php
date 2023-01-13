    <div class="slider-area">
        	<!-- Slider -->
			<div class="block-slider block-slider4">
				<ul class="slides" id="bxslider-home4">
					<li>
						<img src="./vendor/PERSONAL/template/client-site/img/stufeshop-banner-shoope3.png" alt="Slide">
					</li>
					<li>
                        <img src="./vendor/PERSONAL/template/client-site/img/banner-stufeshop.png" alt="Slide">
					</li>
					<li>
                        <img src="./vendor/PERSONAL/template/client-site/img/stufeshop-banner-shoope2.png" alt="Slide">
					</li>
				</ul>
			</div>
			<!-- ./Slider -->
    </div> <!-- End slider area -->
    
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product">
                        <h2 class="section-title">Produtos</h2>
                        <div class="product-carousel">

                            <?php

                            foreach ($product as $key => $value) {
                                
                                echo "<div class='single-product'>";
                                echo "<div class='product-f-image'>";
                                echo "<img src='./vendor/PERSONAL/template/adm-site/uploaded-files/".$product[$key]['imgproduct']."' alt='imagem do produto'>";
                                echo "<div class='product-hover'>";
                                echo "<a href='#' class='add-to-cart-link'><i class='fa fa-shopping-cart'></i> Adicionar ao Carrinho</a>";
                                echo "<a href='#' class='view-details-link'><i class='fa fa-link'></i> Ver Detalhes</a>";
                                echo "</div>";
                                echo "</div>";                                    
                                echo "<h2><a href='http://localhost/ecommerce/products/".$product[$key]['desurl']."'>".$product[$key]['desproduct']."</a></h2>";
                                echo "<div class='product-carousel-price'>";
                                echo "<ins>";
                                echo "R$";
                                echo $visual->formatprice($product[$key]['vlprice']);
                                echo "</ins>";
                                echo "</div>";
                                echo "</div>";

                                if ($key === 10) break;
                            }

                            ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
    
    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <div class="brand-list">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand1.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand2.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand3.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand4.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand5.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand6.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand1.png" alt="">
                            <img src="./vendor/PERSONAL/template/client-site/img/brand2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End brands area -->