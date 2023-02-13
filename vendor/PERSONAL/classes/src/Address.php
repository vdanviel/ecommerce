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

		$sql = new DBconnect();
	
		$result = $sql->select("CALL sp_addresses_save(:idaddress, :idperson, :desaddress, :descomplement, :descity, :desstate, :descountry, :deszipcode, :desdistrict)", array(
			":idaddress" => $this->getidaddress(),
			":idperson" => $this->getidperson(),
			":desaddress" => $this->getdesaddress(),
			":descomplement" => $this->getdescomplement(),
			":descity" => $this->getdescity(),
			":desstate" => $this->getdesaddress(),
			":descountry" => $this->getdescountry(),
			":deszipcode" => $this->getdeszipcode(),
			":desdistrict" => $this->getdesdistrict()
		));

		return $result;
	
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