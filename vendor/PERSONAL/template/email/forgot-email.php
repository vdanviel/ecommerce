<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StufeShopping Email Sending</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
      .top{
    background: #184f92;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 10px;
}
.top .col{
    color: #ffffff;
    align-items: center;
    display: flex;
}
.text-body{
    display: flex;
    flex-direction: column;
    align-items: center;
}
.text-cell h3{
    padding-top: 10px;
    color: #313131;
}
.text-cell p,h3{
    color: #838383;
}
.btn{
    background-color: #184f92;
    border: none;
    padding: 10px;
    margin-bottom: 25px;
}
.btn h5{
    color: #ffffff;
    margin: 0;
}
.btn:hover{
    background-color: #3a85e0;
}
    </style>
  </head>
  <body>

    <div class="container top">
        <div class="row">
            <div class="col">
                <img src="../client-site/img/stuffshoplogoemail.jpeg" alt="stuffshop logo" height="80px">    
            </div>
            <div class="col">
                <nobr><h4>Contact StufeShop</h4></nobr>
            </div>
        </div>
    </div>

    <div class="container body">
        <div class="row">
          <div class="col text-body">
            <div class="text-cell">
              <h3>Recuperação de senha</h3>
              <p>Olá, <h6>$_POST['desperson']<h6></p>
              <p>Para redefinir a sua senha acesse o link:<br> <a href="$_POST['link']">$_POST['link']</a></p>
              <button type="button" class="btn"><a href="$link"><h5>Recuperar Senha</h5></a></button>
              <p>Atenciosamente,</p>
              <h5>StufeShop</h5>
            </div>
          </div>
        </div>
    </div>

    <div class="container top"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>