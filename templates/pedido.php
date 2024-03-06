<?php
// Include database connection
include '../includes/config/database.php';

$conn = conectarDB();

// Retrieve user ID from session or wherever it's stored
// $user_id = 1; // Example

// Process the submitted order
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: login_register.php");
        exit();
    }else{
        $user_id = $_SESSION['id'];
    }
    $total = 0;
    $order_date = date("Y-m-d");
    $insert_order_query = "INSERT INTO pedidos (usuarios_id, order_date) VALUES ($user_id, '$order_date')";
    mysqli_query($conn, $insert_order_query);

    // Get the ID of the last inserted order
    $order_id = mysqli_insert_id($conn);

    // Insert order details into 'order_details' table
    foreach ($_POST['quantity'] as $stock_id => $quantity) {
        if ($quantity > 0) {
            // Get product price
            $product_query = "SELECT precio FROM stock WHERE id = $stock_id";
            $product_result = mysqli_query($conn, $product_query);
            $product_row = mysqli_fetch_assoc($product_result);
            $price = $product_row['precio'];

            // Calculate total
            $subtotal = $price * $quantity;
            $total += $subtotal;

            // Insert order detail
            $insert_detail_query = "INSERT INTO order_details (quantity, total, stock_id, pedidos_id) VALUES ($quantity, $subtotal, $stock_id, $order_id)";
            mysqli_query($conn, $insert_detail_query);
        }
    }

    // Update total cost in the 'pedidos' table
    $update_query = "UPDATE pedidos SET total = $total WHERE id = $order_id";
    mysqli_query($conn, $update_query);

    // Redirect to a thank you page or anywhere else
    header("Location: gracias.php");
    exit();
}




