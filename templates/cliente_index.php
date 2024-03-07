<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login_register.php");
    exit();
}else{
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href=".././styles/main.css" />
    <title>Área Cliente</title>
</head>
<body>
    <main class="wrap-2 container">
        <h1>Bienvenido <?php echo $username ?></h1>
    
    <?php include 'Components/itemcard.php'?>
    </main>
    
</body>
</html>