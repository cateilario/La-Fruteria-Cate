<?php
try {
    require_once '../admin/index.php';

    $conn = conectarDB();

    if (isset($_POST['insert'])) {
        $nombre = $_POST['create_nombre'];
        $cantidad = $_POST['create_cantidad'];
        $precio = $_POST['create_precio'];
        $categoria = $_POST['create_categoria'];

        $imagen = $_FILES['create_imagen']['name'];
        $imagen_temp = $_FILES['create_imagen']['tmp_name'];

        //cambiar esta ruta a la final. Absoluta para evitar problemas de rutas.
        $upload_directory = "/opt/homebrew/var/www/La-Fruteria/images/";
        move_uploaded_file($imagen_temp, $upload_directory . $imagen);

        $sql = "INSERT INTO stock (nombre , cantidad, precio, categoria, imagen) VALUES ('$nombre', '$cantidad', '$precio', '$categoria', '$imagen')";
        mysqli_query($conn,$sql);
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
