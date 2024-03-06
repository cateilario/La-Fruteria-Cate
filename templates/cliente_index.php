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
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido <?php echo $username ?></h1>
    
<?php include 'Components/itemcard.php'?>
    
</body>
</html>