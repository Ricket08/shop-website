<?php
require 'config/database.php';
require 'config/config.php';
require 'clientesFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];
if(!empty($_POST)){
    $email = trim($_POST['email']);


    if(esNulo([$email])){
        $errors[] = "Debe llenar todos los campos.";
    }
    if(!esEmail($email)){
        $errors[]= "La dirección de correo no es valida.";
    }

    if(count($errors) == 0){
        if(emailExiste($email, $con)){
            $sql = $con->prepare("SELECT usuarios.id, usuarios.token_password, clientes.nombres FROM usuarios 
            INNER JOIN clientes  ON usuarios.id_cliente=clientes.id WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];

            $token = solicitaPassword($user_id,$con);
            if($token !== null){
                require 'Mailer.php';
                $mailer = new Mailer();

                $re_token = $row['token_password'];
                print_r($re_token);
                $url = SITE_URL. '/reset_password.php?id=' . $user_id . '&token=' . $re_token;
                $asunto = "Recuperar password - Tienda Blacklist Shop";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de tu contraseña da click en el siguiente link <a href='$url'>Recuperar contraseña</a>";
                $cuerpo.= "<br>Si no hiciste esta solicitud puedes ignorar este correo.";
                if($mailer->enviarEmail($email,$asunto,$cuerpo)){
                    echo "<p><b>Correo enviado</b></p> $email";
                    echo "<p>Hemos enviado un correo electrónico a la dirección $email  para restablecer la contraseña</p>";
                    
                    exit;
                }
            }
        } else{
            $errors[] = "No existe una cuenta asociada a esta dirección de correo";
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

    <?php include 'menu.php'; ?>

    <main class="form-login m-auto pt-4">
        <h3>Recuperar contraseña</h3>
        <?php mostrarMensajes($errors);?>

        <form action="recupera.php" method="post" class="row g-3" autocomplete="off">
            <div class="form-floating">
                <input class="form-control" type="email" name="email" id="email" placeholder="Correo electronico" required>
                <label for="usuario">Correo electronico</label>
            </div>

            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary">Continuar</button>
            </div>
            <div class="col-12 m-auto pt-3">
                ¿No tiene cuenta? <a href="registro.php">Registrarse</a>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    
    


</body>
</html>