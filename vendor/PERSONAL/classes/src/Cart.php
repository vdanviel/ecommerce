<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;
use PERSONAL\TEMPLATE\Visual;
use PERSONAL\USER\User as User;

class Cart extends Model
{

    const SESSION = 'sessioncart';
    const SESSION_ERROR = 'sessioncarterror';
    const SESSION_CLEAN_POSTALCODE = 'sessioncartcleanpostalcode';

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

        return $obj_cart;

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

        $db->queryCommand("INSERT INTO tb_cartsproducts (idcart, idproduct) VALUES(:idcart, :idproduct)", array(
            ":idcart" => $this->getidcart(),
            ":idproduct" => $product[0]['idproduct']
        ));

        $this->getcalculatetotal();
        
    }

    public function removeproduct($product, $all = false){
        $db = new DBconnect();

        if ($all == true) {
            
            $db->queryCommand("UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL", [
                ':idcart'=>$this->getidcart(),
                ':idproduct'=>$product[0]['idproduct']
            ]);

        }else{

            $db->queryCommand("UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL LIMIT 1", [
                ':idcart'=>$this->getidcart(),
                ':idproduct'=>$product[0]['idproduct']
            ]);

        }

        $this->getcalculatetotal();
    }

    public function listcartproducts(){
        $db = new DBconnect();

        return $db->select("SELECT b.idproduct, b.desproduct , b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, b.imgproduct, COUNT(*) AS nrqtd, SUM(b.vlprice) AS vltotal FROM tb_cartsproducts a INNER JOIN tb_products b ON a.idproduct = b.idproduct WHERE a.idcart = :idcart AND a.dtremoved IS NULL GROUP BY b.idproduct, b.desproduct , b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, b.imgproduct ORDER BY b.desproduct", array(
            ":idcart" => $this->getidcart()
        ));
    }

    public function listcartproductsbyid($idcart){
        $db = new DBconnect();

        return $db->select("SELECT b.idproduct, b.desproduct , b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, b.imgproduct, COUNT(*) AS nrqtd, SUM(b.vlprice) AS vltotal FROM tb_cartsproducts a INNER JOIN tb_products b ON a.idproduct = b.idproduct WHERE a.idcart = :idcart AND a.dtremoved IS NULL GROUP BY b.idproduct, b.desproduct , b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, b.imgproduct ORDER BY b.desproduct", array(
            ":idcart" => $idcart
        ));
    }

    public function listcartproductstotal(){
        $db = new DBconnect();

        $result = $db->select("SELECT SUM(vlprice) AS vlprice, SUM(vlwidth) AS vlwidth, SUM(vlheight) AS vlheight, SUM(vllength) AS vllength, SUM(vlweight) AS vlweight, COUNT(*) AS totalproducts FROM tb_products a INNER JOIN tb_cartsproducts b ON a.idproduct = b.idproduct WHERE b.idcart = :idcart AND dtremoved IS NULL;", array(
            ":idcart" => $this->getidcart()
        ));

        if (count($result) > 0) {
            return $result[0];
        }else {
            return false;
        }

    }

    public function listcartproductstotalbyid($idcart){
        $db = new DBconnect();

        $result = $db->select("SELECT SUM(vlprice) AS vlprice, SUM(vlwidth) AS vlwidth, SUM(vlheight) AS vlheight, SUM(vllength) AS vllength, SUM(vlweight) AS vlweight, COUNT(*) AS totalproducts FROM tb_products a INNER JOIN tb_cartsproducts b ON a.idproduct = b.idproduct WHERE b.idcart = :idcart AND dtremoved IS NULL;", array(
            ":idcart" => $idcart
        ));

        if (count($result) > 0) {
            return $result[0];
        }else {
            return false;
        }

    }

    public function freight($postalcode){

        $postalcode = str_replace("-","",$postalcode);

		$totals = $this->listcartproductstotal();
        
		if ($totals['totalproducts'] > 0) {

            if ($totals['vllength'] < 15) $totals['vllength'] = 15.00;
            if ($totals['vlwidth'] < 10) $totals['vlwidth'] = 10.00;
            if ($totals['vlheight'] < 1) $totals['vlheight'] = 1.00;
            if ($totals['vlweight'] < 10) $totals['vlweight'] = 10.00;

			$qs =([
				'nCdEmpresa'=>'',
				'sDsSenha'=>'',
				'nCdServico'=>'40010',
				'sCepOrigem'=>'08240075',
				'sCepDestino'=>$postalcode,
				'nVlPeso'=>$totals['vlweight'],
				'nCdFormato'=>'1',
				'nVlComprimento'=>$totals['vllength'],
				'nVlAltura'=>$totals['vlheight'],
				'nVlLargura'=>$totals['vlwidth'],
				'nVlDiametro'=>false,
				'sCdMaoPropria'=>'N',
				'nVlValorDeclarado'=>false,
				'sCdAvisoRecebimento'=>'S'
			]);

            $qs = http_build_query($qs);

			$xml = simplexml_load_file("http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?".$qs);

			$result = $xml->Servicos->cServico;

			if ($result->MsgErro !== ''){

				Cart::seterror((string)$result->MsgErro);

			} else {

				Cart::cleanerror();

			}

			$this->setnrdays($result->PrazoEntrega);
			$this->setvlfreight(Cart::formatdecimal($result->Valor));
			$this->setdeszipcode($postalcode);

			$this->savecart();

			return $result;

        }
    }

    //rever
    public function cleanpostalcode($data){

        $data = Cart::getcartfromsession();

        if(!isset($_SESSION[Cart::SESSION_CLEAN_POSTALCODE]) && empty($_SESSION[Cart::SESSION_CLEAN_POSTALCODE])){

            $data = NULL;
            return $data;

        }elseif(isset($data)){
            return $data;            
        }

    }
    //rever fim

    public static function formatdecimal($value){

        $value = str_replace(".","",$value);
        return str_replace(",",".",$value);

    }

    public static function seterror($errormsg){

        $_SESSION[Cart::SESSION_ERROR] = $errormsg;

    }

    public static function geterror(){

        return isset($_SESSION[Cart::SESSION_ERROR]) ? $_SESSION[Cart::SESSION_ERROR] : "";

        Cart::cleanerror();

    }

    public static function cleanerror(){

        $_SESSION[Cart::SESSION_ERROR] = NULL;

    }

    public function updatefreight(){


        if ($this->getdeszipcode() !== '') {
            
            $this->freight($this->getdeszipcode());

        }

    }

    public function getdata(){

		$this->getCalculateTotal();

		return parent::getdata();

	}

	public function getcalculatetotal(){

		$this->updatefreight();

		$total = $this->listcartproductstotal();

		$this->setvlsubtotal($total['vlprice']);
		$this->setvltotal($total['vlprice'] + (float)$this->getvlfreight());

	}

}