<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;

class Product extends Model
{

    public static function findoneproduct($id){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_products WHERE idproduct = :id",array(
            ":id" => $id
        ));

    }

    public static function listdata(){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_products ORDER BY idproduct");

    }

    public function registercategory(){
        $db = new DBconnect();

        $db->queryCommand("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
                ":idproduct" => strtoupper($this->getidproduct()),
                ":desproduct" => $this->getdesproduct()
        ));

        }

    public function editproduct($id){
        $db = new DBconnect();

        $result = $db->queryCommand("UPDATE tb_products SET desproduct='',vlprice='',vlwidth='',vlheight='',vllength='',vlweight='',desurl='' WHERE 1",
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
}
