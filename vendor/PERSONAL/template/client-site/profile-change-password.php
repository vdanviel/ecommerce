
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
                    <h2>Alterar Senha</h2>
                </div>

                <?php

                    if ($passwordsuccess ==! '') {

                        echo "<div class='alert alert-success container' style='margin-top: 10px' alert-dismissible>";
                        echo $passwordsuccess;
                        echo "<button class='close' data-dismiss='alert'>&times;</button>";
                        echo "</div>";

                    }

                    if ($passworderror ==! '') {

                        echo "<div class='alert alert-danger container' style='margin-top: 10px' alert-dismissible>";
                        echo $passworderror;
                        echo "<button class='close' data-dismiss='alert'>&times;</button>";
                        echo "</div>";

                    }
 
                ?>
                
                <form action="http://localhost/ecommerce/profile/password/<?=$iduser?>" method="post">
                    <div class="form-group">
                    <label for="current_pass">Senha Atual</label>
                    <input type="password" class="form-control" id="current_pass" name="current_pass">
                    </div>
                    <hr>
                    <div class="form-group">
                    <label for="new_pass">Nova Senha</label>
                    <input type="password" class="form-control" id="new_pass" name="new_pass">
                    </div>
                    <div class="form-group">
                    <label for="new_pass_confirm">Confirme a Nova Senha</label>
                    <input type="password" class="form-control" id="new_pass_confirm" name="new_pass_confirm">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>

            </div>
        </div>
    </div>
</div>