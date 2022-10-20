<?php 
  require_once('./vendor/autoload.php');
  use \PERSONAL\USER\User;
  $user = new User();
	$dbdisplayuser = User::findoneuser($user->geteditiduser());
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Usuários
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Usuário</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desperson">Nome</label>
              <input type="text" class="form-control" id="desperson" name="desperson" placeholder="Digite o nome" value="<?=$dbdisplayuser[0]['desperson']?>">
            </div>
            <div class="form-group">
              <label for="nrphone">Telefone</label>
              <input type="tel" class="form-control" id="nrphone" name="nrphone" placeholder="Digite o telefone"  value="<?=$dbdisplayuser[0]['nrphone']?>">
            </div>
            <div class="form-group">
              <label for="desemail">E-mail</label>
              <input type="email" class="form-control" id="desemail" name="desemail" placeholder="Digite o e-mail" value="<?=$dbdisplayuser[0]['desemail']?>">
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="inadmin" value="1" <?=$dbdisplayuser[0]['inadmin'] === 1 ? "checked" :""?>> Acesso de Administrador
              </label>
            </div>
            <div>
              <a class="btn btn-danger" href="http://localhost/ecommerce/admin/users/<?=$user->geteditiduser()?>/delete" onclick="return confirm('Deseja realmente excluir este usuário?')"><i class="fa fa-trash"></i> Deletar Usuário</a>
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