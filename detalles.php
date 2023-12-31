<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la operación';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if ($token == $token_tmp){
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0 ){
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $precio = $row['precio'];
            $descripcion = $row['descripcion'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_images = 'img/Productos/'.$id.'/';

            $rutaImg = $dir_images . 'Principal.png';

            if(!file_exists($rutaImg)){
                $rutaImg = 'img/Productos/no-photo.png';
            }
            $imagenes = array();
            $dir = dir($dir_images);
            while(($archivo = $dir->read()) != false){
                if($archivo != 'Principal.png' && (strpos($archivo, 'png') || strpos($archivo, 'png-8'))){
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
        }
        $sqlCaracter = $con->prepare("SELECT DISTINCT(det.id_caracteristica) AS idCat, cat.caracteristica FROM det_prod_caracter AS det INNER JOIN caracteristicas_ AS cat ON det.id_caracteristica=cat.id WHERE det.id_prod=?");
        $sqlCaracter->execute([$id]);
    } else {
        echo 'Error al procesar petición';
        exit;
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

    <!--Contenido-->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $rutaImg;?>" class="d-block w-100" >
                            </div>
                            <?php foreach($imagenes as $img){?>
                                <div class="carousel-item ">
                                    <img src="<?php echo $img;?>" class="d-block w-100" >
                                </div>
                            <?php } ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>



                </div>
                <div class="col-md-6 order-md-2">

                    <h2><?php echo $nombre;?></h2>

                    <?php if($descuento > 0){?>
                        <p><del><?php echo MONEDA . number_format($precio,2,',','.');?></del></p>
                        <h2>
                            <?php echo MONEDA . number_format($precio_desc,2,',','.');?>
                            <small class="text-success"><?php echo $descuento;?>% descuento</small>
                        </h2>
                        <?php } else{ ?>
                            <h2><?php echo MONEDA . number_format($precio,2,',','.');?></h2>
                        <?php }?>
                    <p clas="lead">
                        <?php echo $descripcion;?>
                    </p>
                    <div class="col-3 my-3">
                        <?php
                        while($row_cat = $sqlCaracter->fetch(PDO::FETCH_ASSOC)){
                            $idCat = $row_cat['idCat'];
                            echo $row_cat['caracteristica'];

                            echo "<select class='form-select'>";

                            $sqlDet = $con->prepare("SELECT id, valor, stock FROM det_prod_caracter WHERE id_prod=? AND id_caracteristica=?");
                            $sqlDet->execute([$id,$idCat]);
                            while($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)){
                                echo "<option id='".$row_det['id']."'>".$row_det['valor']."</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    </div>
                    <div class="col-3 my-3">
                        Cantidad: <input class="form-control" id="cantidad" name="cantidad" type="number" min="1" max="10" value="1">
                    </div>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button" onclick="">Comprar Ahora</button>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id;?>, cantidad.value, '<?php echo $token_tmp;?>')">Agregar Al Carrito</button>
                    </div>
                </div>
            </div>
        </div>
            
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        function addProducto(id, cantidad, token){
            let url = 'carrito.php'
            let formData = new FormData()
            formData.append('id',id)
            formData.append('cantidad',cantidad)
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