<?php

namespace PERSONAL;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;

class Category extends Model
{

    public static function listdata(){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_categories ORDER BY descategory");

    }

}
