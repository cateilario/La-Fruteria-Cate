<?php
require '../includes/config/database.php';
require 'funciones/actualizar.php';
require 'funciones/borrar.php';
require 'funciones/crear.php';

// Se ha modificado stock para poder insertar items-> ALTER TABLE stock MODIFY COLUMN usuarios_id INT DEFAULT NULL;

$conn = conectarDB();

// var_dump($db);
session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['rol'])) {
    // Your code here
    header("Location: ../index.php");
    exit();
}
elseif($_SESSION['rol'] == 1){
    
    $user_id = $_SESSION['id'];
}else{
    header("Location: ../index.php");
}

// Cerrrar session
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM stock";
$queryPedidos = "SELECT p.id, u.username AS user_name, CONCAT(s.nombre, ' (', od.quantity, ')') AS detalle_pedido, p.total, p.order_date
FROM pedidos p
JOIN usuarios u ON p.usuarios_id = u.id
JOIN order_details od ON p.id = od.pedidos_id
JOIN stock s ON od.stock_id = s.id";
$result = mysqli_query($conn, $query);
$join = mysqli_query($conn,$queryPedidos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".././styles/main.css">
    <title>Área Administrador</title>
</head>

<body>
    <main class="wrap-2 container">
        <h1>Panel Administracion</h1>
        <h2>¡Bienvenido <?php echo $_SESSION['username'] ?>!</h2>

        <section class="admin-actions">
            <a href="?logout=true" class="exit-btn">Exit</a>
        
            <form action="#" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Crear producto</legend>
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

                    <button type="submit" name="insert" class="action-btns" >Insertar</button>

                </fieldset>

                <fieldset>
                    <legend>Actualizar producto</legend>
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

                    <button type="submit" name="update" class="action-btns" >Actualizar</button>
                </fieldset>

                <fieldset>
                    <legend>Borrar producto</legend>
                    <label for="delete_id">ID</label>
                    <input type="text" name="delete_id" id="delete_id" placeholder="1,2,3...">
                    <button type="submit" name="delete" class="action-btns" >Borrar</button>
                </fieldset>
            </form>
            <table class="admin-table">
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
                        <?php echo "<img src='../images/{$fruta['imagen']}' width='100' height='100'></img>"; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
    <table class="admin-table">
            <tr>
                <th>Id pedido</th>
                <th>Nombre de usuario</th>
                <th>ID detalle pedido</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($join)): ?>
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
    </section>
</main>
</body>

</html>