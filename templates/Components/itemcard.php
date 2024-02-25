<?php
require_once '../includes/config/database.php';
$conn = conectarDB();

$query = "SELECT * FROM stock";
$result = mysqli_query($conn, $query);
?>

<div>
    <?php foreach ($result as $item): ?>
        <?php echo "<img src='../images/{$item['imagen']}'/>"; ?>
        <h3>
            <?php echo $item['nombre']; ?>
        </h3>

        <p>
            <?php echo $item['precio'] . '$'; ?>

        </p>
        <p>
            <?php echo $item['categoria']; ?>

        </p>
        <input type="button" value="Add">

    <?php endforeach; ?>

</div>