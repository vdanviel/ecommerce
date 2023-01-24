<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;
use PERSONAL\USER\User as User;

class Cart extends Model
{

    const SESSION = "Cart";

    public function savecart(){

        $db = new DBconnect();

        $result = $db->select("CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszipcode, :vlfreight, :nrdays)", array(
            ":idcart" => $this->getidcart(),
            ":dessessionid" => $this->getdessessionid(),
            ":iduser" => $this->getiduser(),
            ":deszipcode" => $this->getdeszipcode(),
            ":vlfreight" => $this->getvlfreight(),
            ":nrdays" => $this->getnrdays()
        ));

        $this->setdata($result[0]);
    }

    public static function getcartfromsession(){

        $obj_cart = new Cart();

        if (isset($_SESSION[Cart::SESSION]) && $_SESSION[Cart::SESSION]['idcart'] > 0) {
            
            $obj_cart->findonecart($_SESSION[Cart::SESSION]['idcart']);

        }else{

            $obj_cart->findonesessioncart();

            if (!$obj_cart->getidcart() > 0) {
                
                $data = array(
                    'dessessionid' => session_id(),
                    
                );

                if (User::verifylogin(false) === true) {

                    $user = User::sessionuser();
                    $data['iduser'] = $user->getiduser();

                }

                $obj_cart->setdata($data);
                $obj_cart->savecart();
                $obj_cart->setsession();

            }

        }

    }

    public function setsession(){
        $_SESSION[Cart::SESSION] = $this->getdata();
    }

    public function findonecart($id){

        $db = new DBconnect();

        $result = $db->select("SELECT * FROM tb_carts WHERE idcart = :idcart", array(
            ":idcart" => $id
        ));

        if (count($result) > 0) {
            $this->setdata($result[0]);
        }

    }

    public function findonesessioncart(){

        $db = new DBconnect();

        $result = $db->select("SELECT * FROM tb_carts WHERE dessessionid = :dessessionid", array(
            ":dessessionid" => session_id()
        ));

        if (count($result) > 0) {
            $this->setdata($result[0]);
        }

    }

    public function addproduct($product){

        $db = new DBconnect();

        $db->queryCommand("INSERT INTO tb_cartsproducts(idcart, idproduct) VALUES (:idcart,:idprodcut)", array(
            ":idcart" => $this->getidcart(),
            ":idproduct" => $this->getidproduct()
        ));

    }

    public function removeproduct($product, $all = false){
        $db = new DBconnect();

        if ($all == true) {
            
            $db->queryCommand("UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL", [
                ':idcart'=>$this->getidcart(),
                ':idproduct'=>$product->getidproduct()
            ]);

        }else{

            $db->queryCommand("UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL LIMIT 1", [
                ':idcart'=>$this->getidcart(),
                ':idproduct'=>$product->getidproduct()
            ]);

        }


    }


    }
