<?php
// Include database connection
require '../includes/config/database.php';

$conn = conectarDB();

// Fetch products from the database
$query = "SELECT * FROM stock";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <h2>Productos</h2>
    <form action="pedido.php" method="post">
        <?php foreach($result as $product): ?>
            <div class="item-card">
                <?php echo "<img src='../images/{$product['imagen']}' alt='{$product['nombre']}'>"; ?>
                <h3><?php echo $product['nombre'] ?></h3>
                <p><?php echo $product['precio'] ?></p>
                <input type="number" name="quantity[<?php echo $product['id']; ?>]" value="0" min="0">
            </div>
            <?php endforeach; ?>
            <input type="submit" value="Hacer Pedido">
        </form>
</body>
</html>
