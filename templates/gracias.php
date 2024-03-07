<?php
require "../includes/config/database.php";

$conn = conectarDB();

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login_register.php");
    exit();
} else {
    $user_id = $_SESSION['id'];
}

// Cerrrar session
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}


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
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href=".././styles/main.css" />
    <title>Resumen Pedido</title>
</head>
<body>
    <main class="wrap-2 container">
        <h1>¡Gracias por tu pedido!</h1>
        <fieldset class="order-details" >
            <legend>Resumen</legend>
            <p>Fecha Pedido: <span> <?php echo $order['order_date']; ?></span></p>
            
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
            <p>Total:<span class="total-price">$<?php echo number_format($order['total'], 2); ?></span></p>
    </fieldset>
    <a class="grey-btn" href="?logout=true">Volver a la tienda</a>
    </main>
</body>
</html>
