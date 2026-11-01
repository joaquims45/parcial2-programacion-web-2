<?php
require_once __DIR__ . '/../../config/base_url.php';
include_once(__DIR__ . '/../../config/database.php');

$categorias = $conexion->query("SELECT * FROM categorias");

$categoria_id = (int) ($_GET['categoria'] ?? 0);
$buscar_nombre = trim($_GET['buscar_por_nombre'] ?? '');

$sql = "SELECT * FROM juegos";
$condiciones = [];
$tipos = '';
$parametros = [];

if ($categoria_id > 0) {
    $condiciones[] = "categoria_id = ?";
    $tipos .= 'i';
    $parametros[] = $categoria_id;
}
if ($buscar_nombre !== '') {
    $condiciones[] = "nombre LIKE ?";
    $tipos .= 's';
    $parametros[] = '%' . $buscar_nombre . '%';
}
if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY id";

$stmt = $conexion->prepare($sql);
if (!empty($parametros)) {
    $stmt->bind_param($tipos, ...$parametros);
}
$stmt->execute();
$juegos = $stmt->get_result();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juegos</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/juegos/styles.css">
</head>

<body>
<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>
<div class="layout">
    <aside class="filtros">
        <h2>Filtros</h2>
        <?php include_once(__DIR__ . '/../../components/buscar-juegos/index.php'); ?>
        <ul>
            <li><a href="?<?php echo $buscar_nombre !== '' ? 'buscar_por_nombre=' . urlencode($buscar_nombre) : ''; ?>" class="<?php echo $categoria_id === 0 ? 'activo' : ''; ?>">Todas</a></li>
            <?php foreach ($categorias as $categoria): ?>
                <li>
                    <a href="?categoria=<?php echo (int) $categoria['id']; ?><?php echo $buscar_nombre !== '' ? '&buscar_por_nombre=' . urlencode($buscar_nombre) : ''; ?>"
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
            <p>No se encontraron juegos.</p>
        <?php endif; ?>

        <?php foreach ($juegos as $juego): ?>
        <div class="juego-card">
            <img src="<?php echo htmlspecialchars(url_imagen($juego['imagen'])); ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>">
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
