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
        <table>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['imagen'] ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><input type="number" name="quantity[<?php echo $row['id']; ?>]" value="0" min="0"></td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" value="Place Order">
    </form>
</body>
</html>
