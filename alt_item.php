<?php
include "index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="alt_item.php" method="post" id="view">
        <input type="number" placeholder="id" name="id">
        <input type="text" placeholder="nome" name="nome"><br>
        <input type="number" placeholder="valor de venda" name="venda">
        <input type="number" placeholder="valor de compra" name="compra"><br>
        <select name="status" form="view">
            <option></option>
            <option value="encomenda">Encomenda</option>
            <option value="inventário">Inventário</option>
            <option value="anúncio">Anúncio</option>
            <option value="vendido">Vendido</option>
        </select>
        <input type="submit" value="pesquisar" name="submit"><br><br>
    </form>
</body>
</html>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


<?php

$prepare = 'SELECT * FROM `cartas`';


$conditions = [];


if(!empty($_POST['id'])) {
    $conditions[] = '`id_cartas` = :id';
}

if(!empty($_POST['nome'])) {
    $conditions[] = '`nome` = :nome';
}

if(!empty($_POST['venda'])) {
    $conditions[] = '`venda` = :venda';
}

if(!empty($_POST['compra'])) {
    $conditions[] = '`compra` = :compra';
}

if(!empty($_POST['compra'])) {
    $conditions[] = '`compra` = :compra';
}

if(!empty($_POST['status'])) {
    $conditions[] = '`status` = :status';
}

if(!empty($conditions)) {
    $prepare .= ' WHERE ' . implode(' AND ', $conditions);
}


$teste = $conn->prepare($prepare);


if(!empty($_POST['id'])) {
    $teste->bindValue(':id', $_POST['id']);
}

if(!empty($_POST['nome'])) {
    $teste->bindValue(':nome', $_POST['nome']);
}

if(!empty($_POST['venda'])) {
    $teste->bindValue(':venda', $_POST['venda']);
}

if(!empty($_POST['compra'])) {
    $teste->bindValue(':compra', $_POST['compra']);
}

if(!empty($_POST['status'])) {
    $teste->bindValue(':status', $_POST['status']);
}

$teste->execute();

$echo = $teste->fetchAll(PDO::FETCH_ASSOC);


foreach ($echo as $linha) {

    foreach ($linha as $coluna => $valor){

        if(!isset($valor)) { continue; }

            echo $coluna . " -- " . $valor . "<br>";
    }
    echo "<br>";
}
