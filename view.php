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

//veja a "iteração dos filtros" no arquivos.md para se infomrar do funcionamento desse foreach e a idéia que o originou

$filtros = ['id', 'nome', 'venda', 'compra', 'status'];

$prepare = 'SELECT * FROM `cartas`';

foreach ($filtros as $f)
{
    $operador = $f == 'venda' || $f == 'compra' ? 'LIKE' : '=';

    if(!empty($_POST[$f])) {
        $conditions[] = "`$f` $operador :$f"; // ex: "`venda` LIKE :venda";
    }
}

if(!empty($conditions))
{
    $prepare .= ' WHERE ' . implode(' AND ', $conditions);
}

$consulta = $conn->prepare($prepare);

foreach ($filtros as $f)
{
    if(!empty($_POST[$f])) {
        $consulta->bindValue(":$f", $_POST[$f]);
    }
}

$consulta->execute();

$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);


?> 
<div class="container">
    <table border="1">
        <tr>
            <th>id</th> <th>nome</th> <th>venda</th> <th>compra</th> <th>status</th>
            <th>cooldown</th> <th>trocado por</th> <th>editar/excluir</th>
        </tr>
<?php


foreach ($resultado as $linha) {

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
        <td><a href="alt_item.php?id=<?php echo $linha_id; ?>&alt=edit"><input type="button" value="editar/excluir"></a></td>
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
