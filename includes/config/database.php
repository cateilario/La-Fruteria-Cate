<?php
function conectarDB()
{
    $db = mysqli_connect('localhost', 'root', 'Thrasher87?', 'fruteria', 3307);
    if (!$db) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        exit;
    }
    return $db;
}