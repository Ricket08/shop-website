<?php
require 'config/database.php';
require 'config/config.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$db = new Database();
$con = $db->conectar();


$json = file_get_contents('php://input');
$datos = json_decode($json,true);

$idTransaccion = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

if($idTransaccion != ''){

    $fecha = date('Y-m-d H:i:s');
    $idCliente = $_SESSION['user_cliente'];
    $sqlProd = $con->prepare("SELECT email FROM clientes WHERE id=? AND estatus=1 LIMIT 1");
    $sqlProd->execute([$idCliente]);
    $row_cliente = $sqlProd->fetch(PDO::FETCH_ASSOC);
    $email = $row_cliente['email'];


    // $id_transaccion = $datos['detalles']['id'];
    // $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    // $status = $datos['detalles']['status'];
    // $fecha = $datos['detalles']['update_time'];
    // $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    // //$email = $datos['detalles']['payer']['email_address'];
    // //$email = $row_cliente['email'];
    // $id_cliente = $datos['detalles']['payer']['payer_id'];
    
    // $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra =?");
    // $sqlDet->execute([$idCliente]);
    // $row_prod_total = $sqlDet->fetch(PDO::FETCH_ASSOC);
    
    // $precio = $row_prod_total['precio'];
    // $cantidad = $row_prod_total['cantidad'];
    // $total = $precio * $cantidad;

    // print_r($total);
    // $print_r($total);

    $comando = $con->prepare("INSERT INTO compra ( fecha, status, email, id_cliente, total, id_transaccion, medio_pago) VALUES (?,?,?,?,?,?,?)");
    //$sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $idCliente, $total]);
    if($status == 'approved'){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if($productos != null){
            foreach($productos as $clave => $cantidad){
                $sql = $con->prepare("SELECT id,nombre,precio, descuento FROM productos WHERE 
                id=? AND activo=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);
                $total += $precio_desc;
            }
            $comando->execute([$fecha,'COMPLETED', $email, $idCliente, $total, $idTransaccion, 'Mercado Pago']);
        }
        
    }

    $id = $con->lastInsertId();

    if ($id > 0){

        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if($productos != null){
            foreach($productos as $clave => $cantidad){
                $sql = $con->prepare("SELECT id,nombre,precio, descuento FROM productos WHERE 
                id=? AND activo=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                $sql_insert->execute([$id, $row_prod['id'], $row_prod['nombre'], $precio_desc,$cantidad]);
            }
            require 'Mailer.php';
            
            $asunto = "Detalles de su pedido";
            $cuerpo = '<h4>Gracias por su compra</h4>';
            $cuerpo.= '<p>El ID de su compra es <b>' . $idTransaccion . '</b></p>';
            
            $mailer = new Mailer();
            $mailer->enviarEmail($email,$asunto,$cuerpo);
        }
        header("Location: ". SITE_URL . "/completado.php?key=".$idTransaccion);
        unset($_SESSION['carrito']);
    }
}

?>