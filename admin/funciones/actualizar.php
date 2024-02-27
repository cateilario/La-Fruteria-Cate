<?php
try {
    require_once '../admin/index.php';

    $conn = conectarDB();

    $id = '';
    $nombre = '';
    $cantidad = '';
    $precio = '';
    $categoria = '';
    $errores = array();

    if (isset($_POST['update'])) {
        $id = $_POST['update_id'];
        $nombre = $_POST['update_nombre'];
        $cantidad = $_POST['update_cantidad'];
        $precio = $_POST['update_precio'];
        $categoria = $_POST['update_categoria'];

        $imagen = isset($_FILES['update_imagen']) ? $_FILES['update_imagen'] : null;

        if (empty($nombre) && empty($cantidad) && empty($precio) && empty($categoria) && empty($imagen)) {
            $errores[] = 'Nada que actualizar. Todos los campos están vacíos.';
        }

        if (!empty($errores)) {
            foreach ($errores as $error) {
                echo $error . '<br>';
            }
        } else {
            $sql = "UPDATE stock SET";

            // se insertan los campos si estan escritos con concatenacion.
            if (!empty($nombre)) {
                $sql .= " nombre='$nombre',";
            }

            if (!empty($cantidad)) {
                $sql .= " cantidad='$cantidad',";
            }

            if (!empty($precio)) {
                $sql .= " precio='$precio',";
            }

            if (!empty($categoria)) {
                $sql .= " categoria='$categoria',";
            }

            if ($imagen && $imagen['error'] != UPLOAD_ERR_NO_FILE) {
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

                $upload_directory = "../images/";
                move_uploaded_file($imagen['tmp_name'], $upload_directory . $nombreImagen);

                $sql .= " imagen='$nombreImagen',";
            }

            // Borrar la coma
            $sql = rtrim($sql, ',');

            $sql .= " WHERE id='$id'";
            mysqli_query($conn, $sql);

            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
