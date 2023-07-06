<?php

    define("CLIENT_ID",""); //complete with store id generated in your account of PayPal
    define("TOKEN_MP",""); //complete with token of mercado_pago test store or store generated in your account
    define("MP_KEY",""); //complete with password of mercado_pago test store or store generated in your account
     
    #Configuración del sistema
    define("SITE_URL","http://localhost/Tienda_Blacklisto_Facu");
    define("CURRENCY","ARS");
    define("KEY_TOKEN","QKJ.12-kM:SK*"); //This parameters key is created for you
    define("MONEDA","$");

    define("MAIL_HOST","smtp.gmail.com");
    define("MAIL_USER",""); //complete with the user gmail who send e-mail
    define("MAIL_PASS",""); //complete with your SMPT password generated for gmail account
    define("MAIL_PORT","465");

    session_start();
    $num_cart = 0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
    }
?>