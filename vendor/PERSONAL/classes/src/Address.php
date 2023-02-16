<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;
use PERSONAL\TEMPLATE\Visual;
use PERSONAL\USER\User as User;

class Address extends Model{

const SESSION_ADDRESS_ERROR = "sessionaddresserrror";

public static function getcep($cep){

    $viacep = "https://viacep.com.br/ws/$cep/json";

    $curl = curl_init($viacep);

    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $curl_data = json_decode(curl_exec($curl),true);

    curl_close($curl);

    return $curl_data;
}

public function setaddressdata($cep){

		$curl_data = Address::getcep($cep);

		if (isset($curl_data['logradouro']) && empty($curl_data['logradouro'])) {

			$this->setdesaddress($curl_data['logradouro']);
			$this->setdescomplement($curl_data['complemento']);
			$this->setdesdistrict($curl_data['bairro']);
			$this->setdescity($curl_data['localidade']);
			$this->setdesstate($curl_data['uf']);
			$this->setdescountry('Brasil');
			$this->setdeszipcode($cep);
            
		}

    }

	public function saveaddress(){

		$db = new DBconnect();

		$results = $db->select("CALL sp_addresses_save(:idaddress, :idperson, :desaddress, :desnumber, :descomplement, :descity, :desstate, :descountry, :desdistrict)", [
			':idaddress'=>$this->getidaddress(),
			':idperson'=>$this->getidperson(),
			':desaddress'=>utf8_decode($this->getdesaddress()),
			':desnumber'=>$this->getdesnumber(),
			':descomplement'=>utf8_decode($this->getdescomplement()),
			':descity'=>utf8_decode($this->getdescity()),
			':desstate'=>utf8_decode($this->getdesstate()),
			':descountry'=>utf8_decode($this->getdescountry()),
			':desdistrict'=>$this->getdesdistrict()
		]);

		if (count($results) > 0) {
			$this->setdata($results[0]);
		}
	
	}

	public static function seterror($errormsg){

        $_SESSION[Address::SESSION_ADDRESS_ERROR] = $errormsg;

    }

    public static function geterror(){

        $item = isset($_SESSION[Address::SESSION_ADDRESS_ERROR]) ? $_SESSION[Address::SESSION_ADDRESS_ERROR] : "";

        Address::cleanerror();

        return $item;

    }

    public static function cleanerror(){

        $_SESSION[Address::SESSION_ADDRESS_ERROR] = NULL;

    }

}