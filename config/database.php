<?php
class Database
{
    private $hostname = ""; //Complete the variable with your hostname
    private $database = ""; //Complete the variable with your database
    private $username = ""; //Complete the variable with your username
    private $password = ""; //Complete the variable with your password
    private $charset = "utf8";

    function conectar()
    {
        try{
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . "; chatset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $pdo = new PDO($conexion,$this->username,$this->password,$options);
            return $pdo;
        } catch (PDOException $e){
            echo 'Error Conexión: '.$e->getMessage();
            exit;
        }
    
    }
}




?>