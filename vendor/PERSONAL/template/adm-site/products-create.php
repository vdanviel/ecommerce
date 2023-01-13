<?php use PERSONAL\TEMPLATE\Visual;?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="http://localhost/ecommerce/admin/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="http://localhost/ecommerce/admin/products">Produtos</a></li>
    <li class="active"><a href="http://localhost/ecommerce/admin/products/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Produto</h3><br>
          <b style="color: red;"><?php  echo isset($_POST['nofields'])? "Os campos não podem estar vazios." : "" ?></b>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct">Nome da produto</label>
              <input value="<?=isset($_POST['desproduct'])? $_POST['desproduct']:null?>" type="text" class="form-control" id="desproduct" name="desproduct" placeholder="Digite o nome do produto (54)" maxlength="54">
            </div>
            <div class="form-group">
              <label for="vlprice">Preço</label>
              <input value="<?=isset($_POST['vlprice'])? $_POST['vlprice']:null?>" type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="0.00">
            </div>
            <div class="form-group">
              <label for="vlwidth">Largura</label>
              <input value="<?=isset($_POST['vlwidth'])? $_POST['vlwidth']:null?>" type="number" class="form-control" id="vlwidth" name="vlwidth" step="0.01" placeholder="0.00">
            </div>
            <div class="form-group">
              <label for="vlheight">Altura</label>
              <input value="<?=isset($_POST['vlheight'])? $_POST['vlheight']:null?>" type="number" class="form-control" id="vlheight" name="vlheight" step="0.01" placeholder="0.00">
            </div>
            <div class="form-group">
              <label for="vllength">Comprimento</label>
              <input value="<?=isset($_POST['vllength'])? $_POST['vllength']:null?>" type="number" class="form-control" id="vllength" name="vllength" step="0.01" placeholder="0.00">
            </div>
            <div class="form-group">
              <label for="vlweight">Peso</label>
              <input value="<?=isset($_POST['vlweight'])? $_POST['vlweight']:null?>" type="number" class="form-control" id="vlweight" name="vlweight" step="0.01" placeholder="0.00">
            </div>
              <div class="form-group">
                  <label for="desurl">Url</label>
                  <input value="<?=isset($_POST['desurl'])? $_POST['desurl']:null?>" type="text" class="form-control" id="desurl" name="desurl" placeholder="preview-do-produto-na-url-v1 (54)" maxlength="54">
              </div>
              <!--Imagem-->
              <div class="form-group imgproduct">
                <b><p>Escolha uma imagem*</p></b>
                  <label for="imgproduct">
                      <span class="span-img-preview">
                        <img src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/adminLTE2/dist/img/general/no-preview.jpeg" id="img-preview" alt="img-preview">
                      </span>
                  </label>
                  <input type="file" accept="image/png, image/jpg, image/jpeg"  class="form-control" id="imgproduct" name="imgproduct" onchange="previewfile()">
              </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->