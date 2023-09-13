<?php
include "config.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$id = $_GET['x'];
$i = $_GET['y'];

$consulta = $conn->prepare('SELECT * FROM `cartas` WHERE `id_cartas` = :id');
$consulta->bindValue(':id', $id);
$consulta->execute();
$card = $consulta->fetch(PDO::FETCH_ASSOC);

$id = $card['id_cartas'];
$nome = $card['nome'];
$venda = $card['venda'];
$compra = $card['compra'];
$status = $card['status'];
$cooldown = isset($card['cooldown']) ? $card['cooldown'] : null;
$troca = isset($card['trocado_por']) ? $card['trocado_por'] : null;


if($i == 1) { ?>





<?php }

if($i == 0) { ?>
    



<?php } ?>

</body>
</html>