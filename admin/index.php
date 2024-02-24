<?php
require '../includes/config/database.php';
$conn = conectarDB();

// var_dump($db);

$query = "SELECT * FROM stock";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Crud</title>
</head>

<body>
    <h1>Holaaaa admin</h1>

    <form action="#" method="post">
        <fieldset>
            <legend>Crear</legend>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre">

            <label for="cantidad">Cantidad</label>
            <input type="text" name="cantidad" id="cantidad">

            <label for="precio">Precio</label>
            <input type="text" name="precio" id="precio">

            <label for="categoria"></label>
            <input type="text" name="categoria" id="categoria">

            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen">

        </fieldset>

        <fieldset>
            <legend>Borrar</legend>
            <label for="id">ID</label>
            <input type="text" placeholder="1,2,3...">
            <input type="submit" value="Borrar">
        </fieldset>

        <fieldset>
            <legend>Actualizar</legend>
            <label for=""></label>
        </fieldset>
    </form>

    <table border="1px solid black">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>Imagen</th>
        </tr>
        <?php foreach ($result as $fruta): ?>
            <tr>
                <td>
                    <?php echo $fruta['id']; ?>
                </td>
                <td>
                    <?php echo $fruta['nombre']; ?>
                </td>
                <td>
                    <?php echo $fruta['cantidad']; ?>
                </td>
                <td>
                    <?php echo $fruta['precio']; ?>
                </td>
                <td>
                    <?php echo $fruta['categoria']; ?>
                </td>
                <td>
                    <?php echo "<img>" . $fruta['imagen'] . "</img>"; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>