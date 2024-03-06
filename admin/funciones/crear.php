<?php
try {
    require_once '../admin/index.php';

    $conn = conectarDB();

    $nombre = '';
    $cantidad = '';
    $precio = '';
    $categoria = '';
    $errores = array();

    if (isset($_POST['insert'])) {
        $nombre = $_POST['create_nombre'];
        $cantidad = $_POST['create_cantidad'];
        $precio = $_POST['create_precio'];
        $categoria = $_POST['create_categoria'];

        // Comprobar 'create_imagen' existe en $_Files
        $imagen = isset($_FILES['create_imagen']) ? $_FILES['create_imagen'] : null;

        if (empty($nombre)) {
            $errores[] = 'El campo Nombre es obligatorio.';
        }

        if (empty($cantidad)) {
            $errores[] = 'El campo Cantidad es obligatorio.';
        }

        if (empty($precio)) {
            $errores[] = 'El campo Precio es obligatorio.';
        }

        if (empty($categoria)) {
            $errores[] = 'El campo Categoría es obligatorio.';
        }

        $medida = 1000 * 500;

        if ($imagen && $imagen['error'] != UPLOAD_ERR_OK) {
            $errores[] = 'Error al subir imagen.';
        } elseif ($imagen && $imagen['size'] > $medida) {
            $errores[] = 'La imagen es muy pesada.';
        }

        if (!empty($errores)) {
            foreach ($errores as $error) {
                echo $error . '<br>';
            }
        } else {

            //Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            $upload_directory = "../images/";
            move_uploaded_file($imagen['tmp_name'], $upload_directory . $nombreImagen);

            $sql = "INSERT INTO stock (nombre , cantidad, precio, categoria, imagen) VALUES ('$nombre', '$cantidad', '$precio', '$categoria', '$nombreImagen')";
            mysqli_query($conn, $sql);

            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

