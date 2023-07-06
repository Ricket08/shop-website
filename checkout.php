<?php
require 'config/database.php';
require 'config/config.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_carrito= array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id,nombre,precio, descuento, $cantidad AS cantidad FROM productos WHERE 
        id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[]= $sql->fetch(PDO::FETCH_ASSOC);
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

    <main>
        <div class="container">
            <div clas="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                        <tbody>
                                <?php if($lista_carrito == null){
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></tr></tr>';
                                } else {
                                    $total =0;
                                    foreach($lista_carrito as $producto){
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $descuento = $producto['descuento'];
                                        $cantidad = $producto['cantidad'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal;
                                    ?>

                                <tr>
                                    <td><?php echo $nombre;?></td>
                                    <td><?php echo MONEDA . number_format($precio_desc,2,',','.');?></td>
                                    <td>
                                        <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id;?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,',','.'); ?></div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id;?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                    <p class="h3" id="total" ><?php echo MONEDA . number_format($total,2,',','.');?></p>
                                    </td>

                                </tr>
                        </tbody>
                    <?php } ?>
                    </thead>
                </table>
            </div>

            <?php if($lista_carrito != null){ ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <?php if(isset($_SESSION['user_cliente'])){ ?>
                        <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
                    <?php } else { ?>
                        <a href="login.php?pago" class="btn btn-primary btn-lg">Realizar pago</a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" role="dialog" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                    
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>

        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event){
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
            })

        function actualizaCantidad(cantidad, id){
            let url = 'actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action','agregar')
            formData.append('id',id)
            formData.append('cantidad',cantidad)

            fetch(url,{
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    let divsubtotal = document.getElementById('subtotal_' + id)
                    divsubtotal.innerHTML = data.sub
                    
                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')
                    
                    for( let i = 0; i < list.length; i++){
                        total += parseFloat(list[i].innerHTML.replace(/[$,]/g,''))
                    }

                    total = new Intl.NumberFormat('en-US',{
                        minimumFractionDigits: 3    
                    }).format(total)
                    document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
                }
            })
        }

        function eliminar(){
            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value 

            let url = 'actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action','eliminar')
            formData.append('id',id)


            fetch(url,{
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    location.reload()
                }
            })
        }
    </script>

</body>
</html>