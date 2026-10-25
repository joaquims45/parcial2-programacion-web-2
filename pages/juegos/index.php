<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juegos</title>


</head>
<?php
    include_once(__DIR__ . '/../../config/database.php');
?>

<?php
$conexion = new mysqli($host, $usuario, $password, $database);
?>

<?php $juegos = $conexion->query("SELECT * FROM juegos"); ?>


<body>

<?php foreach ($juegos as $juego):  ?>
   <div>
       <h2><?php echo $juego['nombre']; ?></h2>
       <p><?php echo $juego['descripcion']; ?></p>
       <p>Precio: $<?php echo number_format($juego['precio'], 2); ?></p>
       <p>Stock: <?php echo $juego['stock']; ?></p>
       <img src="<?php echo $juego['imagen']; ?>" alt="<?php echo $juego['nombre']; ?>" width="200">
   </div>
<?php endforeach; ?>

</body>
</html>



