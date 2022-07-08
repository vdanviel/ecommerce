<?php

namespace PERSONAL\USER;

use PERSONAL\DB\DBconnect;
use PERSONAL\Model;

class User extends Model{

    const SESSION = "user";

    public static function login($email, $password){
        
        $db = new DBconnect();

        $result = $db->select("SELECT * FROM tb_users WHERE desemail = :EMAIL", array(
            ":EMAIL" => $email,
        ));

        if (count($result) == 0) {
            echo("Usuário inexistente ou senha inválida.<br>");

            return false;
        }
        
        $source = $result[0];

        if (password_verify($password, $source['despassword']) == true) {
            $user = new User();
            
            $user->setdata($source);

            $_SESSION[User::SESSION] = $user->getdata();

            return $user;

        }else{
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
        $_SESSION[User::SESSION]["inadmin"] ==! $inadmin
        )
        {
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

}