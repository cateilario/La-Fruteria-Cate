<?php
try {
    require_once '../admin/index.php';

    $conn = conectarDB();

    if (isset($_POST['delete'])) {
        $id = $_POST['delete_id'];

        // Recoger los datos
        $sql_select = "SELECT imagen FROM stock WHERE id = '$id'";
        $result = mysqli_query($conn, $sql_select);

        if ($result) {
            $fruta = mysqli_fetch_assoc($result);

            // Borrar de la DB
            $sql_delete = "DELETE FROM stock WHERE id = '$id'";
            mysqli_query($conn, $sql_delete);

            // Para eliminar la imagen
            unlink('../images/' . $fruta['imagen']);

            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo 'Error fetching item from database.';
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
