<?php
require 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TEST-5284174884315794-050223-881428aea5c5e03b3cc9687adad7bd0f-608859798');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item ->id = '0001';
$item ->Title = 'Remera Stonewash';
$item ->quantity = 1;
$item ->unit_price = 150.00;
$item ->currency_id = "ARS";

$preference->items = array($item);

$preference->back_urls = array(
    "success" => "http://localhost/Tienda_Blacklisto_Facu/captura_.php",
    "failure" => "http://localhost/Tienda_Blacklisto_Facu/fallo.php"
);

$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h3>Mercado pago</h3>

    <div class="checkout-btn"></div>

    <script>
        const mp = new MercadoPago('TEST-6a37e353-cc02-48be-962c-51188e5e42e9',{
            locale: 'es-AR'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id;?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con MP'
            }
        })
    </script>
</body>
</html>
