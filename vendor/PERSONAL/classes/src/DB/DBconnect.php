<?php
#DAO

class DBconnect extends PDO{

    #conectando
    private $conn;

    public function __construct($host,$dbname,$user,$password,$dbtype="mysql"){

        $this->conn = new PDO("$dbtype:host=$host;dbname=$dbname","$user","$password");

    }

    #parametros
    private function setParams($statment,$parameters = array()){

        foreach ($parameters as $key => &$value) {
            $statment->bindParam($key, $value);
        }

    }

    #comando e execuxão
    public function queryCommand($queryLine,$params = array()){

        $stmt = $this->conn->prepare($queryLine);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
    }

    #comando SELECT
    public function select($rawQuery,$params = array()):array
    {
        $stmt = $this->queryCommand($rawQuery, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>