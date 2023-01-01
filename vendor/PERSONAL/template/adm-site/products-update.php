<?php require_once("vendor/autoload.php"); use \PERSONAL\TEMPLATE\Visual;?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct">Nome da produto</label>
              <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="Digite o nome do produto" value="<?=$data[0]['desproduct']?>">
            </div>
            <div class="form-group">
              <label for="vlprice">Preço</label>
              <input type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="0.00" value="<?=$data[0]['vlprice']?>">
            </div>
            <div class="form-group">
              <label for="vlwidth">Largura</label>
              <input type="number" class="form-control" id="vlwidth" name="vlwidth" step="0.01" placeholder="0.00" value="<?=$data[0]['vlwidth']?>">
            </div>
            <div class="form-group">
              <label for="vlheight">Altura</label>
              <input type="number" class="form-control" id="vlheight" name="vlheight" step="0.01" placeholder="0.00" value="<?=$data[0]['vlheight']?>">
            </div>
            <div class="form-group">
              <label for="vllength">Comprimento</label>
              <input type="number" class="form-control" id="vllength" name="vllength" step="0.01" placeholder="0.00" value="<?=$data[0]['vllength']?>">
            </div>
            <div class="form-group">
              <label for="vlweight">Peso</label>
              <input type="number" class="form-control" id="vlweight" name="vlweight" step="0.01" placeholder="0.00" value="<?=$data[0]['vlweight']?>">
            </div>
            <div class="form-group">
              <label for="desurl">Url</label>
              <input type="text" class="form-control" id="desurl" name="desurl" placeholder="preview-do-produto-na-url-v1" value="<?=$data[0]['desurl']?>">
            </div>
            <!--Imagem-->
            <div class="form-group imgproduct">
                <b><p>Escolha uma imagem*</p></b>
                  <label for="imgproduct">
                      <span class="span-img-preview">
                        <img src="<?php Visual::levelTheRoute()?>./vendor/PERSONAL/template/adm-site/uploaded-files/<?=$data[0]['imgproduct']?>" id="img-preview" alt="img-preview">
                      </span>
                  </label>
                  <input type="file" accept="image/png, image/jpg, image/jpeg"  class="form-control" id="imgproduct" name="imgproduct" onchange="previewfile()">
              </div>
            <div style="margin-bottom:10px;">
              <a class="btn btn-danger" href="http://localhost/ecommerce/admin/products/<?=$data[0]['idproduct']?>/delete" onclick="return confirm('Deseja realmente deletar esse produto?')"><i class="fa fa-trash"></i> Deletar Produto</a>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->