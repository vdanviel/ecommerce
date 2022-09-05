<?php

namespace PERSONAL;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer{
    private $mail;
    const email = 'stuffshopecommerce@gmail.com';
    const password = 'wppwvzbvueomgury';
    //const frompassword = 'mayhconiewjgjpfz';

    public function __construct(){

            $this->mail = new PHPMailer();
            //$this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->isSMTP();#indica que o metodo será SMTP
            $this->mail->Host = "smtp.gmail.com";#host do SMTP
            $this->mail->SMTPAuth = true;#indica que quer se autenticar no host do SMTP

            #AUTENTICANDO-SE NO SMTP
            $this->mail->Username = Mailer::email;#usuário SMTP
            $this->mail->Password = Mailer::password;#senha SMTP
            $this->mail->Port=465;#587 ou 465 são as portas SMTP
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; #encripta a mensagem
        
    }

    public function prepare($toaddress,$toname,$subject,$template,$img){

        #corpo do email
        $this->mail->msgHTML($template);

        #imagem da empresa
        $this->mail->addEmbeddedImage("E:/Arquivos de Programas/Xampp/htdocs/ecommerce/vendor/PERSONAL/classes/src/mailerimages" . "/$img", "mailerimg");
        #quem ira enviar o email
        $this->mail->setFrom(Mailer::email);

        #assunto do email
        $this->mail->Subject = utf8_decode($subject);

        #quem ira receber o email
        $this->mail->addAddress($toaddress,$toname);

    }

    public function sendemail(){
        return $this->mail->send();
    }

}