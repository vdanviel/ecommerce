<?php

namespace PERSONAL\ORDER;

use \PERSONAL\ORDER\OrderStatus;
use \PERSONAL\DB\DBconnect;
use \PERSONAL\Model;

class Order extends Model{

    const SESSION_CHANGE_STATUS_SUCCESS = 'sessionchangestatussuccess';
    const SESSION_CHANGE_STATUS_ERROR = 'sessionchangestatuserror';
    
    public function saveorder(){

        $db = new DBconnect();

		$results = $db->select("CALL sp_orders_save(:idorder, :idcart, :iduser, :idstatus, :idaddress, :vltotal)", [
			':idorder'=>$this->getidorder(),
			':idcart'=>$this->getidcart(),
			':iduser'=>$this->getiduser(),
			':idstatus'=>$this->getidstatus(),
			':idaddress'=>$this->getidaddress(),
			':vltotal'=>$this->getvltotal()
		]);

		if (count($results) > 0) {
			$this->setdata($results[0]);
		}

    }

    public function findoneorder($idorder){

        $db = new DBconnect();

        return $db->select("
        SELECT * FROM tb_orders o 
        INNER JOIN tb_ordersstatus os ON os.idstatus = o.idstatus
        INNER JOIN tb_carts c ON c.idcart = o.idcart
        INNER JOIN tb_users u ON u.iduser = o.iduser
        INNER JOIN tb_addresses a ON a.idaddress = o.idaddress
        INNER JOIN tb_persons p ON p.idperson = u.idperson
        WHERE o.idorder = $idorder ORDER BY o.dtregister");

        
    }

    public function listorders(){

        $db = new DBconnect();

        return $db->select("
        SELECT * FROM tb_orders o 
        INNER JOIN tb_ordersstatus os ON os.idstatus = o.idstatus
        INNER JOIN tb_carts c ON c.idcart = o.idcart
        INNER JOIN tb_users u ON u.iduser = o.iduser
        INNER JOIN tb_addresses a ON a.idaddress = o.idaddress
        INNER JOIN tb_persons p ON p.idperson = u.idperson
        ORDER BY o.dtregister DESC");

    }

    public function listorderuser($iduser){ #lista os pedidos do usuário

        $db = new DBconnect();

        return $db->select("
        SELECT * FROM tb_orders o 
        INNER JOIN tb_ordersstatus os ON os.idstatus = o.idstatus
        INNER JOIN tb_carts c ON c.idcart = o.idcart
        INNER JOIN tb_users u ON u.iduser = o.iduser
        INNER JOIN tb_addresses a ON a.idaddress = o.idaddress
        INNER JOIN tb_persons p ON p.idperson = u.idperson
        WHERE u.iduser = $iduser ORDER BY o.dtregister");

    }

    public function cancelorder($idorder){
        $db = new DBconnect();

        $db->queryCommand('UPDATE tb_orders SET idstatus= '.OrderStatus::CANCELADO.' WHERE tb_orders.idorder = :idorder',array(
            ':idorder' => $idorder
        ));
    }

    public function updateorder($idstatus,$idorder){
        $db = new DBconnect();

        $db->queryCommand('UPDATE tb_orders SET idstatus= :idstatus WHERE tb_orders.idorder = :idorder',array(
            ':idstatus' => $idstatus,
            ':idorder' => $idorder
        ));
    }

    public function liststatusorder(){
        $db = new DBconnect();

        return $db->select('SELECT * FROM tb_ordersstatus');
    }

    #CHANGE ORDER STATUS
    #SUCCESS
    public static function statussetsuccess($msg){

        $_SESSION[Order::SESSION_CHANGE_STATUS_SUCCESS] = $msg;

    }

    public static function statusgetsuccess(){

        $item = isset($_SESSION[Order::SESSION_CHANGE_STATUS_SUCCESS]) ? $_SESSION[Order::SESSION_CHANGE_STATUS_SUCCESS] : "";

        Order::statuscleansuccess();

        return $item;

    }

    public static function statuscleansuccess(){

        $_SESSION[Order::SESSION_CHANGE_STATUS_SUCCESS] = NULL;

    }

    #ERROR
    public static function statusseterror($msg){

        $_SESSION[Order::SESSION_CHANGE_STATUS_ERROR] = $msg;

    }

    public static function statusgeterror(){

        $item = isset($_SESSION[Order::SESSION_CHANGE_STATUS_ERROR]) ? $_SESSION[Order::SESSION_CHANGE_STATUS_ERROR] : "";

        Order::statuscleanerror();

        return $item;

    }

    public static function statuscleanerror(){

        $_SESSION[Order::SESSION_CHANGE_STATUS_ERROR] = NULL;

    }

}


?>