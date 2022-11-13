<?php
namespace PERSONAL\DB;

define("DB_INFO",[
    "127.0.0.1",
    "db_ecommerce",
    "root",
    "",
    "mysql"
]);

class DBconnect{

    #conectando
    private $conn;

    public function __construct($host=DB_INFO[0],$dbname=DB_INFO[1],$user=DB_INFO[2],$password=DB_INFO[3],$dbtype=DB_INFO[4]){

        $this->conn = new \PDO("$dbtype:host=$host;dbname=$dbname","$user","$password");

    }

    public function getconnection(){
        return $this->conn;
    }

    #parametros
    private function setParams($statment,$parameters = array()){

        foreach ($parameters as $key => &$value) {
            $statment->bindParam($key, $value);
        }

    }

    #comando e execuxão somente
    public function queryCommand($queryLine,$params = array()){

        $stmt = $this->conn->prepare($queryLine);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
    }

    #comando e retorna algo (esse usa fetchAll)
    public function select($rawQuery,$params = array())
    {
        $stmt = $this->queryCommand($rawQuery, $params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>