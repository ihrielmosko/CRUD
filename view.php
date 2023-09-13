<?php
include "index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view.css">
    <title>Document</title>
</head>
<body>
    <form action="view.php" method="post" id="view">
        <input type="number" placeholder="id" name="id">
        <input type="text" placeholder="nome" name="nome">
        <input type="number" placeholder="valor de venda" name="venda" step="any">
        <input type="number" placeholder="valor de compra" name="compra" step="any">
        <select name="status" form="view">
            <option></option>
            <option value="encomenda">Encomenda</option>
            <option value="inventário">Inventário</option>
            <option value="anúncio">Anúncio</option>
            <option value="vendido">Vendido</option>
        </select>
        <input type="submit" value="pesquisar" name="submit"><br><br>
    </form>

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
    $conditions[] = '`venda` LIKE :venda';
}

if(!empty($_POST['compra'])) {
    $conditions[] = '`compra` LIKE :compra';
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

?> 
<div class="container">
    <table border="1">
        <tr>
            <th>id</th>
            <th>nome</th>
            <th>venda</th>
            <th>compra</th>
            <th>status</th>
            <th>cooldown</th>
            <th>trocado por</th>
            <th>editar</th>
            <th>excluir</th>
        </tr>
<?php



foreach ($echo as $linha) {

    $linha_id = 0

    ?><tr><?php

    foreach ($linha as $coluna => $valor){

        ?><td <?php

        if(!isset($valor) || $valor == 0) {
            $valor = null; 
            echo " class=\"null\"";
        }

        if(is_int($valor)) { $linha_id = $valor;}

        ?>><?php echo $valor ?></td><?php
    }

    ?>
        <td><a href="alt_item.php?x=<?php echo $linha_id; ?>&y=1"><input type="button" value="editar"></a></td>
        <td><a href="alt_item.php?x=<?php echo $linha_id; ?>&y=0"><input type="button" value="excluir"></a></td>
    </tr>
    <?php
}

if(isset($_POST['submit'])) {

    ?><script>
    window.history.replaceState( null, null, window.location.href );
    </script><?php
}

 ?>
    </table>
</div>
</body>
</html>
