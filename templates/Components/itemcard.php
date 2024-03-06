<?php
require_once '../includes/config/database.php';
$conn = conectarDB();

$query = "SELECT * FROM stock";
$result = mysqli_query($conn, $query);
?>

<div>
    <h1>Realizar Pedido</h1>
    <form action="pedido.php" method="post">
    <?php foreach ($result as $item): ?>
        <?php echo "<img src='../images/{$item['imagen']}'/>"; ?>
        <h3>
            <?php echo $item['nombre']; ?>
        </h3>

        <p>
            Precio: <?php echo $item['precio'] . '$'; ?>

        </p>
        <p>
            Categoría: <?php echo $item['categoria']; ?>

        </p>
        <input type="button" value="Add">

    <?php endforeach; ?>

    </form>

</div>