<?php 
require_once '../includes/config/database.php';
$conn = conectarDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h2>Login</h2>
        <label for="username">User name</label>
        <input type="text" name="username" placeholder="User name">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>

    <?php
    try {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST["username"]);
            $password = $_POST["password"];

            $name = mysqli_real_escape_string($conn, $name);
            $password = mysqli_real_escape_string($conn, $password);

            $query = "SELECT * FROM usuarios WHERE username = '$name' AND password = '$password'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                echo '<p class="success">Login correcto</p>';
            } else {
                echo '<p class="error">No existe</p>';
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
</html>
