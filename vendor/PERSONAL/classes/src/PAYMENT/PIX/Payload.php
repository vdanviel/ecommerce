<?php

namespace PERSONAL\PAYMENT\PIX;

use \PERSONAL\Model;
use \chillerlan\QRCode\QRCode;

class Payload extends Model{

    //ids do Payload do pix
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

   
    #id of the deal
    private $pixid;

    #pix key
    private $pixkey;

    #deal description
    private $pixdescription;

    #merchant name
    private $pixmerchantname;

    #merchant city
    private $pixmerchantcity;

    #deal value (money)
    private $pixvalue;

    #set and get
    public function setgetpixkey($value){
        $this->pixkey = $value;
        return $this;
    }
    public function setgetpixdescription($value){
        $this->pixdescription = $value;
        return $this;
    }
    public function setgetpixmerchantname($value){
        $this->pixmerchantname = strlen($value) > 25 ? false : $value;
        return $this;
    }
    public function setgetpixmerchantcity($value){
        $this->pixmerchantcity = $value;
        return $this;
    }
    public function setgetpixvalue($value){
        $this->pixvalue = (string)number_format($value,2,'.','');
        return $this;
    }
    public function setgetpixid($value){
        $this->pixid = $value;
        return $this;
    }
    
    #CÓDIGO FONTE COMPLETO
    #gera os códigos necessários de todas as infos
    public function getcode($id,$value){
        $size = str_pad(strlen($value),2,"0",STR_PAD_LEFT);//para medir o tamanho do valor
        return $id.$size.$value;//retornando todas as info necessárias
    }

    #retornar o código do formato do payload
    public function getpayloadcode(){

        $payload = 
        $this->getcode(Payload::ID_PAYLOAD_FORMAT_INDICATOR, "1").#tipo do formato do codigo
        $this->getmerchantaccount().#retornar o código das informações da conta do mercador
        $this->getcode(self::ID_MERCHANT_CATEGORY_CODE,"0000").#retornar tipo de mercador (categoria de mercador)
        $this->getcode(self::ID_TRANSACTION_CURRENCY,"986").#retornar o tipo de transação (R$)
        $this->getcode(self::ID_TRANSACTION_AMOUNT,$this->pixvalue).#valor da transação
        $this->getcode(self::ID_COUNTRY_CODE,"BR").#retornar código do país
        $this->getcode(Payload::ID_MERCHANT_NAME,$this->pixmerchantname).#retornar nome do mercador
        $this->getcode(Payload::ID_MERCHANT_CITY,$this->pixmerchantcity).#retornar cidade do mercador
        $this->getaddicionalinfo();#retorna informações adicionais

        #codigo de pagamentp copia-cola pix
        #retorna o payload + código hash (código para validação)
        return $payload.$this->getCRC16($payload);

    }

    #qr code do payload
    public function getpayloadqrcode(){
        
        $qr = new Qrcode();

        $url = (string)$this->getpayloadcode();

        $img = $qr->render($url);

        return "<img src='".$img."' >";
    }

    #ARRAYS IN DE INFO
    #info do mercante
    private function getmerchantaccount(){
        //dominio do banco
        $gui = $this->getcode(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, "br.gov.bcb.pix");

        //chave pix
        $key = $this->getcode(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->pixkey);

        //descrição do pagamento
        $description = strlen($this->pixdescription) > 0 ? $this->getcode(Payload::ID_MERCHANT_ACCOUNT_INFORMATION,$this->pixdescription) : null;

        //resultado:
        return $this->getcode(self::ID_MERCHANT_ACCOUNT_INFORMATION,$gui.$key.$description);
    }
    #infoemações adicionais necessárias (id do pix)
    private function getaddicionalinfo(){
        //adicional info
        $addicional = $this->getcode(Payload::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID,$this->pixid);

        //result
        return $this->getcode(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE,$addicional);
    }

    #FORMATAR HASH
    #metodo responsável por calcular o valor da hash de validação do código pix
    private function getCRC16($payload){

        //ADICIONA DADOS GERAIS NO PAYLOAD
        $payload .= self::ID_CRC16.'04';

        //DADOS DEFINIDOS PELO BACEN
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        //CHECKSUM
        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $resultado ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                    $resultado &= 0xFFFF;
                }
            }
        }

        //RETORNA CÓDIGO CRC16 DE 4 CARACTERES
        return self::ID_CRC16.'04'.strtoupper(dechex($resultado));
    }

}

