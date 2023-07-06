<?php
require 'config/database.php';
require 'config/config.php';
require 'clientesFunciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if($user_id == '' || $token == ''){
    header("Location: index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

$errors = [];

if(verificaTokenRequest($user_id, $token, $con)){
    echo "No se pudo verificar la información";

    exit;
}

if(!empty($_POST)){

    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$user_id, $token, $password, $repassword])){
        $errors[] = "Debe llenar todos los campos.";
    }


    if(!validaPassword($password, $repassword)){
        $errors[]= "Las contraseñas no coinciden.";
    }

    if(count($errors) == 0){
        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
        if(actualizaPassword($user_id,$pass_hash,$con)){
            echo "Contraseña modificada.<br><a href='login.php'>Iniciar Sesión </a>";
            exit;
        }else{
            $errors[] = "Error al modificar contraseña. Intentalo nuevamente.";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    
    <title>Blacklist Shop</title>
</head>
<body>

    <?php include 'menu.php';?>
    
    <main class="form-login m-auto pt-4">
        <h3>Cambiar contraseña</h3>

        <?php mostrarMensajes($errors); ?>

        <form action="reset_password.php" method="post" class="row g-3" autocomplete="off">

            <input type="hidden" name="user_id" id="user_id" value="<?=$user_id; ?>"/>
            <input type="hidden" name="token" id="token" value="<?=$token; ?>"/>

            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña" required>
                <label for="password">Nueva contraseña</label>

                <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Confirmar contraseña" required>

                
                <div class="d-grid gap-3 col-12">
                    <button type="submit" class="btn btn-primary ">Continuar</button>
                </div>

                <div class="col-12 m-auto pt-3">
                    <a href="login.php">Iniciar Sesión</a>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    
    


</body>
</html>