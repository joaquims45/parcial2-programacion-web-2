<?php
include_once(__DIR__ . '/../../config/database.php');

$conexion = new mysqli($host, $usuario, $password, $database);

$categorias = $conexion->query("SELECT * FROM categorias");

$categoria_id = (int) ($_GET['categoria'] ?? 0);

$sql = "SELECT * FROM juegos";
if ($categoria_id > 0) {
    $sql .= " WHERE categoria_id = $categoria_id";
}
$juegos = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juegos</title>
    <link rel="stylesheet" href="/parcial2-programacion-web-2/styles.css">
    <link rel="stylesheet" href="/parcial2-programacion-web-2/pages/juegos/styles.css">
</head>

<body>
<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>
<div class="layout">
    <aside class="filtros">
        <h2>Filtros</h2>
        <ul>
            <li><a href="?" class="<?php echo $categoria_id === 0 ? 'activo' : ''; ?>">Todas</a></li>
            <?php foreach ($categorias as $categoria): ?>
                <li>
                    <a href="?categoria=<?php echo $categoria['id']; ?>"
                       class="<?php echo $categoria_id === (int) $categoria['id'] ? 'activo' : ''; ?>">
                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <hr> </hr>
    <main class="listado">
        <?php if ($juegos->num_rows === 0): ?>
            <p>No hay juegos en esta categoría.</p>
        <?php endif; ?>

        <?php foreach ($juegos as $juego): ?>
        <div class="juego-card">
            <img src="<?php echo $juego['imagen']; ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>">
            <div class="info">
                <h2><?php echo htmlspecialchars($juego['nombre']); ?></h2>
                <p class="descripcion"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
            </div>
            <div class="datos">
                <p>Stock: <?php echo $juego['stock']; ?></p>    
                <p class="precio">Precio: $<?php echo number_format($juego['precio'], 2); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </main>
</div>

<?php $conexion->close(); ?>

<?php include_once(__DIR__ . '/../../components/footer/index.php'); ?>
</body>
</html>
