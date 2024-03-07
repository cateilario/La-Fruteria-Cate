<?php
function conectarDB()
{
    $db = mysqli_connect('localhost', 'root', 'root', 'fruteria', 3306);
    if (!$db) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        exit;
    }
    return $db;
}