<?php
require 'config/database.php';
require 'config/config.php';
require 'clientesFunciones.php';

$db = new Database();
$con = $db->conectar();

$token = generarToken();
$_SESSION['token'] = $token;

$idCliente = $_SESSION['user_cliente'];

$sql = $con->prepare("SELECT id_transaccion, fecha, status, total, medio_pago  FROM compra WHERE id_cliente=? ORDER BY DATE(fecha) DESC");
$sql->execute([$idCliente]);
$date = $sql->fetch(PDO::FETCH_ASSOC);
$fecha = new DateTime($date['fecha']);
$fecha = $fecha->format('d/m/Y H:i:s');

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

    <main>
        <div class="container">
            <h4>Mis compras</h4>
            <hr>

            <?php while($row = $sql->fetch(PDO::FETCH_ASSOC)){ ?>
                <div class="card mb-3 bg-light border-info">
                    <div class="card-header">
                        <?php echo $fecha; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Folio: <?php echo $row['id_transaccion']; ?></h5>
                        <p class="card-text text-primary">Total: <?php echo MONEDA. '' . number_format($row['total'], 2, ',', '.');?></p>
                        <a href="compra_detalle.php?orden=<?php echo $row['id_transaccion'];?>&token=<?php echo $token;?>" class="btn btn-primary">Ver compra</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    
    


</body>
</html>