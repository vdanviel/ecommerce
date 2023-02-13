    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Autenticação</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

               if ($errorlogin ==! '') {

                    echo "<div class='alert alert-danger container' style='margin-top: 10px' alert-dismissible>";
                    echo $errorlogin;
                    echo "<button class='close' data-dismiss='alert'>&times;</button>";
                    echo "</div>";
    
                }
        
                if ($errorregister ==! '') {

                    echo "<div class='alert alert-danger container' style='margin-top: 10px' alert-dismissible>";
                    echo $errorregister;
                    echo "<button class='close' data-dismiss='alert'>&times;</button>";
                    echo "</div>";
        
                }

    ?>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">                
                <div class="col-md-6">
                    <form action="http://localhost/ecommerce/login" id="login-form-wrap" class="login" method="post">
                        <h2>Acessar</h2>
                        <p class="form-row form-row-first">
                            <label for="email">E-mail
                            </label>
                            <input type="text" id="email" name="email" class="input-text">
                        </p>
                        <p class="form-row form-row-last">
                            <label for="senha">Senha
                            </label>
                            <input type="password" id="senha" name="password" class="input-text">
                        </p>
                        <div class="clear"></div>
                        <p class="form-row">
                            <input type="submit" name="login" value="login"  class="button">
                            <label class="inline" for="rememberme"><input type="checkbox" value="forever" id="rememberme" name="rememberme"> Manter conectado </label>
                        </p>
                        <p class="lost_password">
                            <a href="http://localhost/ecommerce/forgot">Esqueceu a senha?</a>
                        </p>

                        <div class="clear"></div>
                    </form>                    
                </div>
                <div class="col-md-6">

                    <form id="register-form-wrap" action="http://localhost/ecommerce/register" class="register" method="post">
                        <h2>Criar conta</h2>
                        <p class="form-row form-row-first">
                            <label for="nome">Nome Completo
                            </label>
                            <input type="text" id="nome" name="name" class="input-text" value="">
                        </p>
                        <p class="form-row form-row-first">
                            <label for="email">E-mail
                            </label>
                            <input type="email" id="email" name="email" class="input-text" value="">
                        </p>
                        <p class="form-row form-row-first">
                            <label for="phone">Telefone
                            </label>
                            <input type="text" id="phone" name="phone" class="input-text" value="">
                        </p>
                        <p class="form-row form-row-last">
                            <label for="senha">Senha
                            </label>
                            <input type="password" id="senha" name="password" class="input-text">
                        </p>
                        <div class="clear"></div>

                        <p class="form-row">
                            <input type="submit" value="register" name="login" class="button">
                        </p>

                        <div class="clear"></div>
                    </form>               
                </div>
            </div>
        </div>
    </div>