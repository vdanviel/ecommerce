<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;
use PERSONAL\TEMPLATE\Visual;

class Product extends Model{

    public static function findoneproduct($id){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_products WHERE idproduct = :id",array(
            ":id" => $id
        ));

    }

    public static function productdetail($url){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_products INNER JOIN tb_productscategories ON tb_products.idproduct = tb_productscategories.idproduct INNER JOIN tb_categories ON tb_productscategories.idcategory = tb_categories.idcategory WHERE tb_products.desurl = :url LIMIT 1;",array(
            ":url" => $url
        ));

    }

    public static function listdata(){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_products ORDER BY idproduct");

    }

    public function registerproduct(){
        $db = new DBconnect();

        $db->queryCommand("INSERT INTO tb_products (desproduct, vlprice, vlwidth, vlheight, vllength, vlweight, imgproduct, desurl) VALUES(:desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :imgproduct, :desurl);", array(
            ":desproduct" => $this->getdesproduct(),
            ":vlprice" => $this->getvlprice(),
            ":vlwidth" => $this->getvlwidth(),
            ":vlheight" => $this->getvlheight(),
            ":vllength" => $this->getvllength(),
            ":vlweight" => $this->getvlweight(),
            ":imgproduct" => $_FILES["imgproduct"]["name"],
            ":desurl" => $this->getdesurl()
        ));

        $path = "./vendor/PERSONAL/template/adm-site/uploaded-files";
        
        move_uploaded_file($_FILES["imgproduct"]["tmp_name"], $path."/".$_FILES["imgproduct"]["name"]);
    }

    public static function listpageitens_products($itensperpage, $page = 1){

        $start = ($page - 1) * $itensperpage;

        $db = new DBconnect();

        $result = $db->select("SELECT * FROM tb_products LIMIT $start, $itensperpage");

        $rows_total = $db->select("SELECT COUNT(*) FROM tb_products");

        $info = [$result, ceil($rows_total[0]["COUNT(*)"] / $itensperpage)];

        return $info;

    }

    public function editproduct($id){
        $db = new DBconnect();

        if ($_FILES['imgproduct']['name'] == null) {
            
            $db->queryCommand("UPDATE tb_products SET desproduct=:desproduct, vlprice=:vlprice, vlwidth=:vlwidth, vlheight=:vlheight, vllength=:vllength, vlweight=:vlweight, desurl=:desurl WHERE idproduct = :id",
            array(
                ":desproduct" => $this->getdesproduct(),
                ":vlprice" => $this->getvlprice(),
                ":vlwidth" => $this->getvlwidth(),
                ":vlheight" => $this->getvlheight(),
                ":vllength" => $this->getvllength(),
                ":vlweight" => $this->getvlweight(),
                ":desurl" => $this->getdesurl(),
                ":id" => $id
            ));

        }

        if ($_FILES['imgproduct']['name'] ==! null) {

            #excluir o arquivo primeiro
            $dataimg = Product::findoneproduct($id);
            $img = $dataimg[0]['imgproduct'];

            $path_to_delete = "./vendor/PERSONAL/template/adm-site/uploaded-files/$img";
        
            if (file_exists($path_to_delete)) {
                unlink($path_to_delete);
            }else {
                echo "File cannot be deleted.";
            }
            
            #processo de substituição dos dados
            $db->queryCommand("UPDATE tb_products SET desproduct=:desproduct, vlprice=:vlprice, vlwidth=:vlwidth, vlheight=:vlheight, vllength=:vllength, vlweight=:vlweight, desurl=:desurl, imgproduct=:imgproduct WHERE idproduct = :id",
            array(
                ":desproduct" => $this->getdesproduct(),
                ":vlprice" => $this->getvlprice(),
                ":vlwidth" => $this->getvlwidth(),
                ":vlheight" => $this->getvlheight(),
                ":vllength" => $this->getvllength(),
                ":vlweight" => $this->getvlweight(),
                ":imgproduct" => $_FILES['imgproduct']['name'],
                ":desurl" => $this->getdesurl(),
                ":id" => $id
            ));

            #adicionar nova foto
            $path = "./vendor/PERSONAL/template/adm-site/uploaded-files";
        
            var_dump($_FILES['imgproduct']);

            move_uploaded_file($_FILES['imgproduct']['tmp_name'], $path."/".$_FILES['imgproduct']['name']);

        }

    }

    public function deleteproduct($id){

        $db = new DBconnect();

        #excluir o arquivo primeiro
        $dataimg = Product::findoneproduct($id);
        $img = $dataimg[0]['imgproduct'];

        $path_to_delete = "./vendor/PERSONAL/template/adm-site/uploaded-files/$img";
        
        if (file_exists($path_to_delete)) {
            unlink($path_to_delete);
        }else {
            return "File cannot be deleted.";
        }

        #excluir o registro
        $db->queryCommand("DELETE FROM tb_products WHERE idproduct = :id",
        array(
            ":id" => $id
        ));
        
    }

}
