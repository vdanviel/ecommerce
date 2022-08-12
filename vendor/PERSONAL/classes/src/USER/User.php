<?php

namespace PERSONAL\USER;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;

class User extends Model
{

    const SESSION = "user";

    /*$geteditiduser - a função desse metodo é pegar o id do user pela URI atual para o crud.
    Este metodo pega o id que está na rota da pagina users-update ou seja, ele SOMENTE FUNCIONARA lá.
    (pelo menos puramente)
    Ele serve para coletar o ID atual para edição do user*/
    public static function geteditiduser(){
        $editiduser = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],"/",17) + 1,strlen($_SERVER['REQUEST_URI']));#O TERCEIRO PARAMETRO DO STRPOS VAI TER QUEM MUDAR PARA 6 QUANDO ENTRAR NO SERVIDOR;
        return $editiduser;
    }

    public static function login($email, $password){

        $db = new DBconnect();

        $result = $db->select("SELECT * FROM tb_users WHERE desemail = :EMAIL", array(
            ":EMAIL" => $email,
        ));

        if (count($result) == 0) {
            echo ("Usuário inexistente ou senha inválida.<br>");

            return false;
        }

        $source = $result[0];

        if (password_verify($password, $source['despassword']) == true) {
            $user = new User();

            $user->setdata($source);

            $_SESSION[User::SESSION] = $user->getdata();

            return $user;
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.<br>");

            return false;
        }
    }

    public static function verifylogin($inadmin = 1){
        if (
            empty($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            empty($_SESSION[User::SESSION]["iduser"])
            ||
            $_SESSION[User::SESSION]["inadmin"] == !$inadmin
        ) {
            header("Location: http://localhost/ecommerce/admin/login");
            exit;
            return "Usuário sem login ativo.";
        } else {
            return "Usuário com login ativo.";
        }
    }

    public static function logout(){

        $_SESSION[User::SESSION] = NULL;
        header("location: http://localhost/ecommerce");
    }

    public static function listdata(){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_users INNER JOIN tb_persons USING(idperson) ORDER BY tb_persons.desperson");

    }

    public static function findoneuser($id){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_users INNER JOIN tb_persons USING(idperson) WHERE iduser = $id ORDER BY tb_persons.desperson;");

    }

    public function registeruser(){
        $db = new DBconnect();
            
        $result = $db->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)",
        array(
            ":desperson" => $this->getdesperson(),
            ":deslogin" => strtoupper($this->getdesperson()),
            ":despassword" => $this->getdespassword(),
            ":desemail" => $this->getdesemail(),
            ":nrphone" => $this->getnrphone(),
            ":inadmin" => $this->getinadmin()
        ));
        
        $this->setdata($result[0]);
    }

    public function edituser(){
        $db = new DBconnect();
            
        $result = $db->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)",
        array(
            ":iduser" => substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],"/",17) + 1,strlen($_SERVER['REQUEST_URI'])),
            ":desperson" => $this->getdesperson(),
            ":deslogin" => strtoupper($this->getdesperson()),
            ":despassword" => $this->getdespassword(),
            ":desemail" => $this->getdesemail(),
            ":nrphone" => $this->getnrphone(),
            ":inadmin" => $this->getinadmin()
        ));
        
        $this->setdata($result[0]);
    }

    public function deleteuser($id){

        $db = new DBconnect();

        $db->queryCommand("sp_users_delete(:iduser)",
        array(
            ":iduser" => $id
        ));
    }
}
