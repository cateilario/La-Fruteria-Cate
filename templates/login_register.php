<?php
require_once '../includes/config/database.php';
$conn = conectarDB();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link rel="stylesheet" href="/styles/main.css">
    <style>
        /* Hide the registration form initially */
        #registrationForm {
            display: none;
        }
    </style>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Login/Register</h2>
        <label for="username">User name</label>
        <input type="text" name="username" placeholder="User name">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="login">Iniciar</button>
    </form>

    <button type="button" onclick="toggleRegistrationForm()">Registrarse</button>

    <!-- Registration form -->
    <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:none;">
        <h2>Registrarse</h2>
        <label for="newUsername">New User name</label>
        <input type="text" name="newUsername" placeholder="User name">
        <label for="newEmail">Email</label>
        <input type="text" name="newEmail" id="newEmail" placeholder="Email">
        <label for="newPassword">New Password</label>
        <input type="password" name="newPassword" placeholder="Password">

        <button type="submit" name="register">Registrarse</button>

    </form>

    <script>
        function toggleRegistrationForm() {
            var registrationForm = document.getElementById('registrationForm');
            registrationForm.style.display = (registrationForm.style.display === 'none') ? 'block' : 'none';
        }
    </script>

    <?php
    try {
        if (isset($_POST['login'])) {
            $name = trim($_POST["username"]);
            $email = $_POST['email'];
            $password = $_POST["password"];

            $name = mysqli_real_escape_string($conn, $name);
            $password = mysqli_real_escape_string($conn, $password);

            $query = "SELECT * FROM usuarios WHERE username = '$name' AND email = '$email' AND password = '$password'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                if ($row['id'] == 1) {
                    die(header("Location:../admin/index.php"));
                } else {
                    die(header("Location:cliente_index.php"));
                }
            } else {
                echo '<p class="error">Credenciales incorrectas</p>';
            }
        } elseif (isset($_POST['register'])) {
            $name = trim($_POST["newUsername"]);
            $email = $_POST['newEmail'];
            $password = $_POST["newPassword"];

            $name = mysqli_real_escape_string($conn, $name);
            $password = mysqli_real_escape_string($conn, $password);

            $query = "INSERT INTO usuarios (username, email,password) VALUES ('$name','$email','$password')";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            } else {
                echo '<p class="success">Registro exitoso. Puede iniciar sesión ahora.</p>';
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>

</html>