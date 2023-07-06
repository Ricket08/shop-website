<?php


use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};


require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;   // SMTP::DEBUG_OFF                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'drawmeclothes@gmail.com';                     //SMTP username
    $mail->Password   = 'phoimsrijehzmsku';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPDebug = 1;

    //Recipients
    $mail->setFrom('drawmeclothes@gmail.com', 'Blacklist Shop');
    $mail->addAddress('garciad980@gmail.com', 'Joe User');     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de su pedido';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo.= '<p>El ID de su compra es <b>' . $id_transaccion . '</b></p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail ->setLanguage('es','phpmailer/language/phpmailer.lang-es.php');


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra {$mail->ErrorInfo}";
    exit;
}

?>