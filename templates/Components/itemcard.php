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
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href=".././styles/main.css" />
    <title>Productos</title>
</head>
<body>
    <h3>Selecciona los productos que deseas añadir al pedido:</h3>
    <section class="admin-actions">
        <form action="pedido.php" method="post" class="product-actions">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $product): ?>
                        <tr>
                            <td><img width="100" height="100" src='../images/<?php echo $product['imagen']; ?>' alt='<?php echo $product['nombre']; ?>'></td>
                            <td><?php echo $product['nombre']; ?></td>
                            <td><?php echo $product['precio']; ?></td>
                            <td><input type="number" name="quantity[<?php echo $product['id']; ?>]" value="0" min="0"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="submit" value="Hacer Pedido" class="grey-btn">
        </form>
    </section>
</body>
</html>
