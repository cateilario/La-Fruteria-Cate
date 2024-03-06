<?php
require '../includes/config/database.php';
require 'funciones/actualizar.php';
require 'funciones/borrar.php';
require 'funciones/crear.php';

// Se ha modificado stock para poder insertar items-> ALTER TABLE stock MODIFY COLUMN usuarios_id INT DEFAULT NULL;

$conn = conectarDB();

// var_dump($db);

$query = "SELECT * FROM stock";
$query2 = "SELECT * FROM pedidos";
$query3 = "SELECT p.id, u.username AS user_name, CONCAT(s.nombre, ' (', od.quantity, ')') AS detalle_pedido, p.total, p.order_date
FROM pedidos p
JOIN usuarios u ON p.usuarios_id = u.id
JOIN order_details od ON p.id = od.pedidos_id
JOIN stock s ON od.stock_id = s.id";
$result = mysqli_query($conn, $query);
$result2 = mysqli_query($conn, $query2);
$result3 = mysqli_query($conn, $query3);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Crud</title>
</head>

<body>
    <h1>Holaaaa Kikeee</h1>
    <a href="../index.php">Exit</a>

    <form action="#" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Crear</legend>
            <label for="create_nombre">Nombre</label>
            <input type="text" name="create_nombre" id="create_nombre">

            <label for="create_cantidad">Cantidad</label>
            <input type="text" name="create_cantidad" id="create_cantidad">

            <label for="create_precio">Precio</label>
            <input type="text" name="create_precio" id="create_precio">

            <label for="create_categoria">Categoria</label>
            <input type="text" name="create_categoria" id="create_categoria">

            <label for="create_imagen">Imagen</label>
            <input type="file" name="create_imagen" id="create_imagen">

            <button type="submit" name="insert">Insertar</button>

        </fieldset>

        <fieldset>
            <legend>Actualizar</legend>
            <label for="update_id">ID</label>
            <input type="text" name="update_id" id="update_id">

            <label for="update_nombre">Nombre</label>
            <input type="text" name="update_nombre" id="update_nombre">

            <label for="update_cantidad">Cantidad</label>
            <input type="text" name="update_cantidad" id="update_cantidad">

            <label for="update_precio">Precio</label>
            <input type="text" name="update_precio" id="update_precio">

            <label for="update_categoria">Categoria</label>
            <input type="text" name="update_categoria" id="update_categoria">

            <label for="update_imagen">Imagen</label>
            <input type="file" name="update_imagen" id="update_imagen">

            <button type="submit" name="update">Actualizar</button>
        </fieldset>

        <fieldset>
            <legend>Borrar</legend>
            <label for="delete_id">ID</label>
            <input type="text" name="delete_id" id="delete_id" placeholder="1,2,3...">
            <button type="submit" name="delete">Borrar</button>
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
                    <?php echo $fruta['precio'] . '$'; ?>
                </td>
                <td>
                    <?php echo $fruta['categoria']; ?>
                </td>
                <td>
                    <?php echo "<img src='../images/{$fruta['imagen']}'></img>"; ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>

    <table border="1px solid black">
        <tr>
            <th>Id pedido</th>
            <th>Nombre de usuario</th>
            <th>ID detalle pedido</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($result2 as $pedido): ?>
            <tr>
                <td>
                    <?php echo $pedido['id']; ?>
                </td>
                <td>
                    <?php echo $pedido['usuarios_id']; ?>
                </td>

                <td>
                    <?php echo $pedido['detalle_pedido']; ?>
                </td>

                <td>
                    <?php echo $pedido['total'] . " €"; ?>
                </td>

                <td>
                    <?php echo $pedido['order_date']; ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <table border="1px solid black">
        <tr>
            <th>Id pedido</th>
            <th>Nombre de usuario</th>
            <th>ID detalle pedido</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result3)): ?>
            <tr>
                <td>
                    <?php echo $row['id']; ?>
                </td>
                <td>
                    <?php echo $row['user_name']; ?>
                </td>

                <td>
                    <?php echo $row['detalle_pedido']; ?>
                </td>

                <td>
                    <?php echo $row['total'] . " €"; ?>
                </td>

                <td>
                    <?php echo $row['order_date']; ?>
                </td>
            </tr>
        <?php endwhile ?>
    </table>
</body>

</html>