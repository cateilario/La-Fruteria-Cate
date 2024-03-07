<?php
require_once '../includes/config/database.php';
$conn = conectarDB();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <title>Login/Register</title>
    <link rel="stylesheet" href=".././styles/main.css">
</head>

<body class="log-in">
    <form class="log-form" id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Inicio sesión</h2>
        <label for="username">Nombre usuario:</label>
        <input type="text" name="username">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <label for="password">Contraseña:</label>
        <input type="password" name="password">
        <div class="form-btns">
            <button type="submit" name="login">Iniciar sesión</button>
            <button type="button" onclick="toggleRegistrationForm()">Registrarse</button>
        </div>
    </form>

    <!-- Registration form -->
    <form class="log-form hidden" id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Registrarse</h2>
        <label for="newUsername">Nombre usuario:</label>
        <input type="text" name="newUsername" placeholder="User name">
        <label for="newEmail">Email:</label>
        <input type="text" name="newEmail" id="newEmail" placeholder="Email">
        <label for="newPassword">Contraseña:</label>
        <input type="password" name="newPassword" placeholder="Password">
        <div class="form-btns">
            <button type="submit" name="register">Registrarse</button>
            <button type="button" onclick="toggleRegistrationForm()" class="back-btn">Volver</button>
        </div>
    </form>

    <script>
        function toggleRegistrationForm() {
            const registrationForm = document.getElementById('registrationForm');
            const loginForm = document.getElementById("loginForm");
            // Toggle the 'hidden' class to control visibility
            registrationForm.classList.toggle('hidden');
            loginForm.classList.add('hidden'); // Oculta el formulario de inicio de sesión
            // Si el formulario de registro está oculto, muestra el de inicio de sesión
            if (registrationForm.classList.contains('hidden')) {
                loginForm.classList.remove('hidden');
            }
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

            $query = "SELECT id, username, email, rol , password FROM usuarios WHERE username = '$name' AND email = '$email'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            }
            // usuarios password tiene que ser 255
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['rol'] = $row['rol'];
                    $_SESSION['id'] = $row['id'];
                    switch ($row['rol']) {
                        case 1:
                            header("Location:../admin/index.php");
                            exit;
                        default:
                            header("Location:cliente_index.php");
                            exit;
                    }
                } else {
                    echo '<p class="error">Credenciales incorrectas</p>';
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

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO usuarios (username, email,password) VALUES ('$name','$email','$hashPassword')";
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