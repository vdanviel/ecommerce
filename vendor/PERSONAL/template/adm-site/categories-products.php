<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Produtos da Categoria <?=$category[0]['descategory']?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="http://localhost/ecommerce/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="http://localhost/ecommerce/admin/categories">Categorias</a></li>
    <li><a href="http://localhost/ecommerce/admin/categories/<?=$category[0]['idcategory']?>/products"><?=$category[0]['descategory']?></a></li>
    <li class="active"><a href="/admin/categories/{$category.idcategory}/products">Produtos</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title">Produtos na Categoria <?=$category[0]['descategory']?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th style="width: 100px"><?=empty($categoryproductTRUE) == true ? '<nobr>Não há produtos nesta categoria.</nobr>' : '&nbsp;'?></th>
                            <th style="width: 10px"><?=empty($categoryproductTRUE) == true ? '' : '#'?></th>
                            <th><?=empty($categoryproductTRUE) == true ? '' : 'Nome do Produto'?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($categoryproductTRUE as $key => $value) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo '<a href="http://localhost/ecommerce/admin/categories/'.$category[0]['idcategory'].'/products/'.$categoryproductTRUE[$key]['idproduct'].'/remove" class="btn btn-primary btn-xs pull-right"><i class="fa fa-trash"></i>&nbsp;&nbsp;Remover</a>';
                                    echo '</td>';
                                    echo '<td>'.$categoryproductTRUE[$key]['idproduct'].'</td>';
                                    echo '<td>'.$categoryproductTRUE[$key]['desproduct'].'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
        
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title">Todos os Produtos</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th style="width: 100px">&nbsp;</th>    
                            <th style="width: 10px">#</th>
                            <th>Nome do Produto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            echo empty($categoryproductFALSE) == true ? 'showtablepreview()' : '';

                            foreach ($categoryproductFALSE as $key => $value) {
                                
                                echo '<tr>';
                                echo '<td>';
                                echo '<a href="http://localhost/ecommerce/admin/categories/'.$category[0]['idcategory'].'/products/'.$categoryproductFALSE[$key]['idproduct'].'/add" class="btn btn-primary btn-xs pull-left"><i class="fa fa-plus"></i>&nbsp;&nbsp;Adicionar</a>';
                                echo '</td>';
                                echo '<td>'.$categoryproductFALSE[$key]['idproduct'].'</td>';
                                echo '<td>'.$categoryproductFALSE[$key]['desproduct'].'</td>';
                                echo '</tr>';

                            }
                            
                            ?>
       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->