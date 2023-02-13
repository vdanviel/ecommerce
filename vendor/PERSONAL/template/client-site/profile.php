
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

            <div class="col-md-9">
                
            <?php

                if ($profilesuccess ==! '') {

                    echo "<div class='alert alert-success container' style='margin-top: 10px' alert-dismissible>";
                    echo $profilesuccess;
                    echo "<button class='close' data-dismiss='alert'>&times;</button>";
                    echo "</div>";


                }
                if ($profileerror ==! '') {

                    echo "<div class='alert alert-danger container' style='margin-top: 10px' alert-dismissible>";
                    echo $profileerror;
                    echo "<button class='close' data-dismiss='alert'>&times;</button>";
                    echo "</div>";

                }

            ?>            
                <form method="post" action="http://localhost/ecommerce/profile">
                    <h3>Alterar Informações</h3>
                    <div class="form-group">
                        <label for="desperson">Nome completo</label>
                        <input type="text" class="form-control" id="desperson" name="desperson" placeholder="Digite o nome aqui" value="<?=$data[0]['deslogin']?>">
                    </div>
                    <div class="form-group">
                        <label for="desemail">E-mail</label>
                        <input type="email" class="form-control" id="desemail" name="desemail" placeholder="Digite o e-mail aqui" value="<?=$data[0]['desemail']?>">
                    </div>
                    <div class="form-group">
                        <label for="nrphone">Telefone</label>
                        <input type="tel" class="form-control" id="nrphone" name="nrphone" placeholder="Digite o telefone aqui" value="<?=$data[0]['nrphone']?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
                <div class="list-group" id="menu">
                    <a href="#" class="list-group-item list-group-item-action">Alterar Senha</a>
                    <a href="#" class="list-group-item list-group-item-action">Meus Pedidos</a>
                    <a href="/logout" class="list-group-item list-group-item-action">Sair</a>
                </div>
            </div>
        </div>
    </div>
    
</div>