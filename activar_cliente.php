<?php
require 'config/database.php';
require 'config/config.php';
require 'clientesFunciones.php';


$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    header("location index.php");
    exit;
}
$db = new Database();
$con = $db->conectar();

echo validaToken($id,$token,$con);



?>