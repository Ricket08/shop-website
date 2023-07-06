<?php
require 'config/database.php';
require 'config/config.php';

$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT id,nombre,precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchall(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.min.css">
    
    <title>Blacklist Shop</title>
</head>
<body>
<?php include 'menu.php';?>

    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
                foreach($resultado as $row){
                ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                        $id = $row['id'];
                        $imagen = "img/Productos/" . $id . "/Principal.png";
                        if(!file_exists($imagen)){
                            $imagen = "img/Productos/no-photo.png";
                        }

                        ?>
                        <img src="<?php echo $imagen; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nombre'];?></h5>
                            <p class="card-text">$<?php echo number_format($row['precio'],2,',','.');?></p>
                            <div class="d-flex justify-content-between aling-items-center">
                                <div class="btn-group">
                                    <a href="detalles.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1',$row['id'], KEY_TOKEN);?>" class="btn btn-primary">Detalles</a>
                                </div>
                                <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id'];?>, '<?php echo hash_hmac('sha1',$row['id'], KEY_TOKEN);?>')">Agregar Al Carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        function addProducto(id, token){
            let url = 'carrito.php'
            let formData = new FormData()
            formData.append('id',id)
            formData.append('token',token)

            fetch(url,{
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero 
                }
            })
        }
    </script>

</body>
</html>