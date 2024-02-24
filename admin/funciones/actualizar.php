<?php
try {

    require_once '../admin/index.php';

    $conn = conectarDB();

    if(isset($_POST['update'])){
        $id = $_POST['update_id'];
        $nombre = $_POST['update_nombre'];
        $cantidad = $_POST['update_cantidad'];
        $precio = $_POST['update_precio'];
        $categoria = $_POST['update_categoria'];

        $imagen = $_FILES['update_imagen']['name'];
        $imagen_temp = $_FILES['update_imagen']['tmp_name'];

        $upload_directory = "../images";
        move_uploaded_file($imagen_temp, $upload_directory . $imagen);

         $sql = "UPDATE stock SET nombre='$nombre', cantidad='$cantidad', precio='$precio', categoria='$categoria'";

         if (!empty($imagen)) {
             $sql .= ", imagen='$imagen'";
         }
 
         $sql .= " WHERE id='$id'";
        mysqli_query($conn,$sql);
    }


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
