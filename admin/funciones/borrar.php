<?php 

try{
    require_once '../admin/index.php';

    $conn = conectarDB();

    if(isset($_POST['delete'])){
        $id = $_POST['delete_id'];

        $sql = "DELETE FROM stock WHERE id = '$id'";
        mysqli_query($conn,$sql);
    }
}catch(Exception $e){
    echo 'Error: ' . $e->getMessage();
}