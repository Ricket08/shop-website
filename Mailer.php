<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer {
    function enviarEmail($email,$asunto,$cuerpo){
        require_once 'config/config.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';
        require 'phpmailer/src/Exception.php';
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;   // SMTP::DEBUG_OFF                   //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;                     //SMTP username
            $mail->Password   = MAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('drawmeclothes@gmail.com', 'Blacklist Shop');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;

            $mail->Body    = utf8_decode($cuerpo);
            $mail->AltBody = $cuerpo;

            $mail ->setLanguage('es','phpmailer/language/phpmailer.lang-es.php');


            if($mail->send()){
                return true;
            } else{
                return false;
            }
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Error al enviar el correo electronico de la compra {$mail->ErrorInfo}";
            return false;
        }
    }
    
}

?>