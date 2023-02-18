<?php

namespace PERSONAL\ORDER;

use \PERSONAL\DB\DBconnect;
use \PERSONAL\Model;

class OrderStatus extends Model{
    
   const EM_ABERTO = 1;
   const AGUARDANDO = 2;
   const PAGO = 3;
   const ENTREGUE = 4;
   const CANCELADO = 5;

   public static function listdata(){

       $db = new DBconnect();

       return $db->select("SELECT * FROM tb_ordersstatus ORDER BY desstatus");

   }

}


?>