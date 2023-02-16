<?php

namespace PERSONAL\ORDER;

use \PERSONAL\DB\DBconnect;
use \PERSONAL\Model;

class Order extends Model{
    
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

        $db->queryCommand('DELETE FROM tb_orders WHERE idorder = :idorder',array(
            ':idorder' => $idorder
        ));
    }

}


?>