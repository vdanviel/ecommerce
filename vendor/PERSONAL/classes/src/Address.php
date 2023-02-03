<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;
use PERSONAL\TEMPLATE\Visual;
use PERSONAL\USER\User as User;

class Address extends Model{

public static function getcep($cep){

    $viacep = "https://viacep.com.br/ws/$cep/json";

    $curl = curl_init($viacep);

    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $curl_obj = curl_exec($curl);

    $data = json_encode($curl_obj,true);

    curl_close($curl);

    return $data;
}

}