<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alt_item</title>
</head>
<body>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php
$id = $_GET['id'];
$alt = $_GET['alt'];

$consulta = $conn->prepare('SELECT * FROM `cartas` WHERE `id` = :id');
$consulta->bindValue(':id', $id);
$consulta->execute();
$card = $consulta->fetch(PDO::FETCH_ASSOC);

$nome = $card['nome'];
$venda = $card['status'] == "anúncio" || $card['status'] == "vendido" ? $card['venda'] : null;
$compra = $card['compra'];
$status = $card['status'];
$cooldown = isset($card['cooldown']) ? $card['cooldown'] : null;

if ($alt == "edit") { ?>

<form action="alt_item.php?id=<?php echo $id;?>&alt=edit" method="post" id="entrada">
    <input type="text" value="id: <?php echo $id;?>" disabled><br>
    <input type="text" placeholder="nome" name="nome" value="<?php echo $nome;?>" required><br>
    <input type="number" placeholder="val. compra" name="compra" step="any" value="<?php echo $compra;?>"><br>
    <input type="number" placeholder="val. venda" name="venda" value="<?php echo $venda;?>" step="any"><br>
    <select name="status" form="entrada" required>
        <option value="<?php echo $status;?>"><?php echo $status;?></option>
        <option value="encomenda">Encomenda</option>
        <option value="inventário">Inventário</option>
        <option value="anúncio">Anúncio</option>
        <option value="vendido">Vendido</option>
    </select><br>
    <input type="date" name="cd">
    <input type="checkbox" name="ncd">sem cooldown</input> <br>
    <input type="submit" name="save" value="salvar">
    <a href="view.php"><input type="button" name="exit" value="voltar"></a><br>

    <?php if(isset($_POST['delete'])) {
        echo "deseja mesmo excluir o item?";
    ?> <br>

        <a href="alt_item.php?id=<?php echo $id;?>&alt=delete"><input type="button" value="sim"></a>
        <a href="alt_item.php?id=<?php echo $id;?>&alt=edit"><input type="button" value="não"></a>

    <?php } ?> <br>
        
    <?php if(!isset($_POST['delete'])) { ?>
        <input type="submit" name="delete" value="excluir">
    <?php } ?>

</form>

<?php

$atributos = ["nome", "venda", "compra", "status",];


if(isset($_POST['save'])) {

    $edit = $conn->prepare('UPDATE `cartas` SET `nome` = :nome, `venda` = :venda, `compra` = :compra, `status` = :status WHERE `cartas`.`id` = :id');
    $edit->bindValue(":id", $id);

    foreach($atributos as $i) {

        $j = empty($i) ? null : $_POST[$i];

        $edit->bindValue(":$i", $j);
    }

    $edit->execute();

    ?><script>
    window.history.replaceState( null, null, window.location.href );
    </script><?php

    header("Refresh:0");
}

}

if ($alt == "delete")
{
    $delete = $conn->prepare('DELETE FROM `cartas` WHERE `cartas`.`id` = :id');
    $delete->bindValue(':id', $id);
    $delete->execute();

    echo "item $id excluído com sucesso";
    
    ?> <a href="view.php"><input type="button" value="ok"></a> <?php

}

?>

</body>
</html>