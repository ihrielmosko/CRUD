<?php
include "index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteamDeck</title>
</head>
<body>
    <form action="nova_entrada.php" method="post" id="entrada">
        <input type="number" placeholder="número de entradas" name="count" required><br><br>
        <input type="text" placeholder="nome da carta" name="nome" required><br>
        <!-- <input type="number" placeholder="valor da venda" name="venda" step="any"><br> -->
        <input type="number" placeholder="valor da compra" name="compra" step="any"><br>
        <select name="status" form="entrada" required>
            <option></option>
            <option value="encomenda">Encomenda</option>
            <option value="inventário">Inventário</option>
            <!-- <option value="anúncio">Anúncio</option> -->
            <!-- <option value="vendido">Vendido</option> -->
        </select><br>
        <input type="date" name="cd">
        <input type="checkbox" name="ncd">sem cooldown</input> <br>
        <input type="submit" name="submit">
    </form>
</body>
</html>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php

if(isset($_POST['submit'])){

    $nome = $_POST['nome'];
    // $venda = $_POST['venda'];
    $compra = $_POST['compra'];
    $status = $_POST['status'];
    $count = $_POST['count'];

    if(isset($_POST['ncd'])) { $cd = NULL; }
    else { $cd = $_POST['cd']; }

    for ($i = 0; $i < $count; $i++) {

        $submit = $conn->prepare('INSERT INTO `cartas` (`id_cartas`, `nome`, `venda`, `compra`, `status`, `cooldown`, `trocado_por`) VALUES (NULL, :nome,/*:venda,*/ NULL, :compra, :status, :cd, NULL)');
        $submit->bindValue(':nome', $nome);
        // $submit->bindValue(':venda', $venda);
        $submit->bindValue(':compra', $compra);
        echo $compra;
        $submit->bindValue(':status', $status);
        $submit->bindValue(':cd', $cd);
        $submit->execute();
    }
}
?>