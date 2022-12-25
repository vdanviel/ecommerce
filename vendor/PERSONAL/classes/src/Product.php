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

    public static function listdata(){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_products ORDER BY idproduct");

    }

    public function registerproduct(){
        $db = new DBconnect();

        $tmp_file = $_FILES['imgproduct'];//VAR PARA A IMAGEM

        $db->queryCommand("INSERT INTO tb_products (desproduct, vlprice, vlwidth, vlheight, vllength, vlweight, imgproduct, desurl) VALUES(:desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :imgproduct, :desurl);", array(
            ":desproduct" => $this->getdesproduct(),
            ":vlprice" => $this->getvlprice(),
            ":vlwidth" => $this->getvlwidth(),
            ":vlheight" => $this->getvlheight(),
            ":vllength" => $this->getvllength(),
            ":vlweight" => $this->getvlweight(),
            ":imgproduct" => $tmp_file['name'],
            ":desurl" => $this->getdesurl()
        ));

        $path = "./vendor/PERSONAL/template/adm-site/uploaded-files";
        
        if (move_uploaded_file($tmp_file['tmp_name'], $path."/".$tmp_file['name'])) {
    		return true;
    	}else{
		    return false;
	    }

        }

    public function editproduct($id){
        $db = new DBconnect();

        $result = $db->queryCommand("UPDATE tb_products SET desproduct=:desproduct, vlprice=:vlprice, vlwidth=:width, vlheight=:vlheight, vllength=:vllenght, vlweight=:vlweight, imgproduct=:imgproduct, desurl=:desurl WHERE idproduct = :id",
            array(
                ":desproduct" => $this->getdesproduct(),
                ":vlprice" => $this->getvlprice(),
                ":vlwidth" => $this->getvlwidth(),
                ":vlheight" => $this->getvlheight(),
                ":vllength" => $this->getvllength(),
                ":vlweight" => $this->getvlweight(),
                ":imgproduct" => $this->getimgproduct(),
                ":desurl" => $this->getdesurl(),
                ":id" => $id
            ));
    }

    public function deleteproduct($id){

        $db = new DBconnect();

        $db->queryCommand("DELETE FROM tb_products WHERE idproduct = :id",
        array(
            ":id" => $id
        ));
    }

}
