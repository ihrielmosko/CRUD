## Iteração dos filtros

```php
if(!empty($_POST['id'])) {
    $condition[] = '`id` = :id';
}

if(!empty($_POST['nome'])) {
    $condition[] = '`nome` = :nome';
}

if(!empty($_POST['venda'])) {
    $condition[] = '`venda` LIKE :venda';
}

if(!empty($_POST['compra'])) {
    $condition[] = '`compra` LIKE :compra';
}

if(!empty($_POST['status'])) {
    $condition[] = '`status` = :status';
}

if(!empty($condition)) {
    $prepare .= ' WHERE ' . implode(' AND ', $condition);
}


$consulta = $conn->prepare($prepare);


if(!empty($_POST['id'])) {
    $consulta->bindValue(':id', $_POST['id']);
}

if(!empty($_POST['nome'])) {
    $consulta->bindValue(':nome', $_POST['nome']);
}

if(!empty($_POST['venda'])) {
    $consulta->bindValue(':venda', $_POST['venda']);
}

if(!empty($_POST['compra'])) {
    $consulta->bindValue(':compra', $_POST['compra']);
}

if(!empty($_POST['status'])) {
    $consulta->bindValue(':status', $_POST['status']);
}

$consulta->execute();


$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
```