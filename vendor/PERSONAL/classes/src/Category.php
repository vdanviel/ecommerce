<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;

class Category extends Model
{

    public static function findonecategory($id){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_categories WHERE idcategory = :id",array(
            ":id" => $id
        ));

    }

    public static function listdata(){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_categories ORDER BY idcategory");

    }

    public function registercategory(){
        $db = new DBconnect();

        #verificando a quantidade de registros
        $records = $db->select("SELECT * FROM tb_categories ORDER BY idcategory");

        if(count($records) >= 5){
            return "Você não pode cadastrar mais de cinco (5) categorias.";
        }else{
            #cadastrando a categoria caso seja 4 <
            $db->queryCommand("CALL sp_categories_save(:idcategory, :descategory)", array(
                ":idcategory" => strtoupper($this->getidcategory()),
                ":descategory" => $this->getdescategory()
            ));
            return "SUCCESS";
        }
    }

    public function editcategory($id){
        $db = new DBconnect();

        $result = $db->queryCommand("UPDATE tb_categories SET descategory = :name WHERE idcategory = :id",
            array(
                ":name" => strtoupper($this->getdescategory()),
                ":id" => $id
            ));
    }

    public function deletecategory($id){

        $db = new DBconnect();

        $db->queryCommand("DELETE FROM tb_categories WHERE idcategory = :id",
        array(
            ":id" => $id
        ));
    }

    public static function listpageitens_category($id, $itensperpage, $page = 1){

        $start = ($page - 1) * $itensperpage;

        $db = new DBconnect();

        $result = $db->select("SELECT * FROM tb_products a INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct INNER JOIN tb_categories c ON b.idcategory = c.idcategory WHERE b.idcategory = :idcategory LIMIT $start, $itensperpage",array(
            ":idcategory" => $id
        ));

        $total_rows = $db->select("SELECT COUNT(*) FROM tb_products a INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct INNER JOIN tb_categories c ON b.idcategory = c.idcategory WHERE b.idcategory = :idcategory LIMIT $start, $itensperpage",array(
            ":idcategory" => $id
        ));

        return [$result, ceil($total_rows[0]["COUNT(*)"] / $itensperpage)];

    }

    public static function getrelatedproducts($id,$related){

        $db = new DBconnect();

        if ($related == true) {
            
            return $db->select("SELECT * FROM tb_products WHERE idproduct IN( SELECT a.idproduct FROM tb_products a INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct WHERE b.idcategory = :id)",array(
                ":id" => $id
            ));

        }else{

            return $db->select("SELECT * FROM tb_products WHERE idproduct NOT IN( SELECT a.idproduct FROM tb_products a INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct WHERE b.idcategory = :id )",array(
                ":id" => $id
            ));

        }

    }
    
    public static function addproduct($idcategory, $idproduct){
        $db = new DBconnect();

        $db->queryCommand("INSERT INTO tb_productscategories ( idcategory, idproduct) VALUES (:idcategory,:idproduct)",array(
            ":idcategory" => $idcategory,
            ":idproduct" => $idproduct
        ));

    }

    public static function removeproduct($idproduct){
        $db = new DBconnect();

        $db->queryCommand("DELETE FROM tb_productscategories WHERE idproduct = :idproduct",array(
            ":idproduct" => $idproduct
        ));

    }

    

}
