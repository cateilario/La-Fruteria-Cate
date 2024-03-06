<?php
require "../includes/config/database.php";

$conn = conectarDB();


// Retrieve user ID from session or wherever it's stored
$user_id = 1; // Example

// Retrieve the last order made by the user
$query = "SELECT * FROM pedidos WHERE usuarios_id = $user_id ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

// Retrieve order details
$order_id = $order['id'];
$order_details_query = "SELECT stock.nombre, order_details.quantity, order_details.total
                        FROM order_details
                        JOIN stock ON order_details.stock_id = stock.id
                        WHERE order_details.pedidos_id = $order_id";
$order_details_result = mysqli_query($conn, $order_details_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
</head>
<body>
    <h2>Gracias por tú pedido!</h2>
    <h3>Resumen</h3>
    <p><strong>Fecha Pedido:</strong> <?php echo $order['order_date']; ?></p>
    <p><strong>Total :</strong> $<?php echo number_format($order['total'], 2); ?></p>
    <h4>Detalles:</h4>
    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($order_details_result)) { ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo number_format($row['total'], 2); ?>$</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
