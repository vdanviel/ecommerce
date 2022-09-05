<?php

namespace PERSONAL\USER;

use PERSONAL\DB\DBconnect;
use PERSONAL\Mailer;
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

        $resultlogin = $db->select("SELECT * FROM tb_persons WHERE desemail = :EMAIL", array(
            ":EMAIL" => $email,
        ));

        if (count($resultlogin) == 0) {
            echo ("Usuário inexistente ou senha inválida.<br>");

            return false;
        }

        $source = $db->select("SELECT * FROM tb_users WHERE iduser = {$resultlogin[0]['idperson']}");

        if (password_verify($password, $source[0]['despassword']) == true) {
            $user = new User();

            $user->setdata($source[0]);

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

    public static function emailrecovery($email){

    #PROCESSO DE ENVIO DE EMAIL
	$db = new DBconnect();

	$result1 = $db->select("SELECT * FROM tb_persons INNER JOIN tb_users on tb_persons.idperson = tb_users.iduser WHERE tb_persons.desemail = :email",array(
		":email" => $email
	));

	if (count($result1) == 0) {
		throw new \Exception("Não foi possível recuperar a senha.");
	}else{
		
		$userinfo = $result1[0];

		$result2 = $db->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
			":iduser"=>$userinfo['iduser'],
			":desip"=>"179.209.251.111"//$_SERVER['REMOTE_ADDR']
		));

		if (count($result2) == 0) {
			throw new \Exception("Não foi possível recuperar a senha.");
		}else {
			
			$dataRecovery = $result2[0];

			$encryptdata = openssl_encrypt($dataRecovery['idrecovery'], 'AES-128-CBC', pack("a16", "Stufesp2051"), 0, pack ("a16", "EcommerceStufeSp"));

			$code = base64_encode ($encryptdata);

			$inadmin = $userinfo['inadmin'];
			
			if ($inadmin === 1) {

				$link = "http://localhost/ecommerce/admin/forgot/reset?code=$code";

			} else {

				$link = "http://localhost/ecommerce/forgot/reset?code=$code";
				
            }

			$template = "
            <!doctype html>
            <html lang='en'>
              <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <title>StufeShopping Email Sending</title>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx' crossorigin='anonymous'>
                <style>
                    .top{
                        background: #184f92;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                        padding: 10px;
                    }
                    .top .col{
                        color: #ffffff;
                        align-items: center;
                        display: flex;
                    }
                    .text-body{
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }
                    .text-cell h3{
                        padding-top: 10px;
                        color: #313131;
                    }
                    .text-cell p,h3{
                        color: #838383;
                    }
                    .btn{
                        background-color: #184f92;
                        border: none;
                        padding: 10px;
                        margin-bottom: 25px;
                    }
                    .btn h5{
                        color: #ffffff;
                        margin: 0;
                    }
                    .btn:hover{
                        background-color: #3a85e0;
                    }
                </style>
              </head>
              <body>

                <div class='container top'>
                    <div class='row'>
                        <div class='col'>
                            <img src='cid:mailerimg' alt='stufeshoplogo' height='80px'>    
                        </div>
                        <div class='col'>
                            <nobr><h4>Contato StufeShop</h4></nobr>
                        </div>
                    </div>
                </div>

                <div class='container body'>
                    <div class='row'>
                      <div class='col text-body'>
                        <div class='text-cell'>
                          <h3>Recuperação de senha</h3>
                          <p>Olá, <h3>".$userinfo['desperson']."<h3></p>
                          <p>Para redefinir a sua senha acesse o link:<br> <a href='$link'>$link</a></p>
                          <button type='button' class='btn'><a href='$link'><h5>Recuperar Senha</h5></a></button>
                          <p>Atenciosamente,</p>
                          <h3>StufeShop</h3>
                        </div>
                      </div>
                    </div>
                </div>

                <div class='container top'></div>

                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa' crossorigin='anonymous'></script>
              </body>
            </html>
            ";

			$mailer = new Mailer();
			$mailer->prepare($userinfo['desemail'],$userinfo['desperson'],"Contato - StuffShop",$template,"mailerimgsend.jpeg");
            $mailer->sendemail();
		    }

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

        return $db->select("SELECT * FROM tb_users INNER JOIN tb_persons USING(idperson) WHERE iduser = $id ORDER BY tb_persons.desperson");

    }

    public static function findoneuserbyemail($email){

        $db = new DBconnect();

        return $db->select("SELECT * FROM tb_users INNER JOIN tb_persons USING(idperson) WHERE desemail = $email ORDER BY tb_persons.desperson");

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

        $db->queryCommand("DELETE tb_users, tb_persons FROM tb_users INNER JOIN tb_persons on tb_persons.idperson = tb_users.iduser WHERE tb_users.iduser = :id",
        array(
            ":id" => $id
        ));
    }
}
