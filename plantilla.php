<?php
require 'config/database.php';
require 'config/config.php';
require 'clientesFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];
if(!empty($_POST)){

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$nombres, $apellidos,$email, $telefono, $dni, $usuario, $password, $repassword])){
        $errors[] = "Debe llenar todos los campos.";
    }
    if(!esEmail($email)){
        $errors[]= "La dirección de correo no es valida.";
    }

    if(!validaPassword($password, $repassword)){
        $errors[]= "Las contraseñas no coinciden.";
    }

    if(usuarioExiste($usuario,$con)){
        $errors[]= "El nombre de usuario $usuario ya existe.";
    }

    if(emailExiste($email,$con)){
        $errors[]= "El Correo electrónico $email ya existe.";
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

    <header data-bs-theme="dark">
        <div class="collapse text-bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                    <h4>About</h4>
                    <p class="text-body-secondary">Somos una tienda online de indumentaria encargada de estampado por pedido a través de técnicas de serigrafía.
                        Actualmente trabajamos con prendas compuestas en mayor parte de algodón. 
                        Empezamos como una idea y terminamos como una empresa.
                        Un proceso, una meta.
                    </p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                    <h4>Contact</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Follow on Instagram</a></li>
                        <li><a href="#" class="text-white">Like on Facebook</a></li>
                        <li><a href="#" class="text-white">Email me</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
            <a href="#" class="navbar-brand ">
                <strong>Blacklist</strong>
            </a>
            <a href="#" class="navbar-brand">Catálogo</a>
            <a href="#" class="navbar-brand">Insumos</a>
            <a href="checkout.php" class="btn btn-primary">
                Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart;?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            </div>
        </div>
    
    </header>

    <main>
        <div class="container">

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    
    


</body>
</html>