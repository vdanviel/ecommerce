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
}
