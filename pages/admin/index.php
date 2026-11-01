<?php include_once(__DIR__ . '/../../config/database.php'); ?>
<?php require_once __DIR__ . '/../../config/base_url.php'; ?>

<?php $sql_categorias = "SELECT * FROM categorias";?>
<?php $resultado_categorias = $conexion->query($sql_categorias);?>

<?php $sql_juegos = "SELECT * FROM juegos";?>
<?php $resultado_juegos = $conexion->query($sql_juegos);?>

<?php $sql_borrar_juego = "DELETE FROM juegos WHERE id = ?";?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_juego_id'])) {
    $juego_id = (int) $_POST['borrar_juego_id'];

    $stmt = $conexion->prepare($sql_borrar_juego);
    $stmt->bind_param('i', $juego_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . BASE_URL . "/pages/admin/index.php");
    exit();
}?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_juego'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = (float) $_POST['precio'];
    $stock = (int) $_POST['stock'];
    $categoria_id = (int) $_POST['categoria_id'];
    $imagen = $_POST['imagen'];

    $sql_agregar_juego = "INSERT INTO juegos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_agregar_juego);
    $stmt->bind_param('ssdiis', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen);
    $stmt->execute();
    $stmt->close();

    header("Location: " . BASE_URL . "/pages/admin/index.php");
    exit();
}?>

<?PHP if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_POST['editar_juego'])) {
    $id = (int) $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = (float) $_POST['precio'];
    $stock = (int) $_POST['stock'];
    $categoria_id = (int) $_POST['categoria_id'];
    $imagen = $_POST['imagen'];

    $sql_editar_juego = "UPDATE juegos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql_editar_juego);
    $stmt->bind_param('ssdiisi', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . BASE_URL . "/pages/admin/index.php");
    exit();
}?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/admin/styles.css">
    <script src="<?php echo BASE_URL; ?>/pages/admin/script.js" defer></script>

</head>

<body>
<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>

<button class="nuevo" type="button" onclick="abrirModal()">+ Nuevo juego</button>

<?php foreach ($resultado_juegos as $juego): ?>

    <?php include_once(__DIR__ . '/../../components/admin-card/index.php'); ?>

<?php endforeach; ?>


<dialog id="agregarJuegoDialog">
    <form method="POST" action="">
    <h2 id="modal-titulo">Agregar Juego</h2>
    <input type="hidden" name="id" id="f-id" value="0">

    <label for="f-nombre">Nombre:</label>
    <input type="text" name="nombre" id="f-nombre" required>

    <label for="f-descripcion">Descripción:</label>
    <textarea name="descripcion" id="f-descripcion" required></textarea>

    <label for="f-precio">Precio:</label>
    <input type="number" step="0.01" name="precio" id="f-precio" required>

    <label for="f-stock">Stock:</label>
    <input type="number" name="stock" id="f-stock" required>

    <label for="f-categoria">Categoría:</label>
    <select name="categoria_id" id="f-categoria" required>
    <?php foreach ($resultado_categorias as $categoria): ?>
        <option value="<?php echo $categoria['id']; ?>">
            <?php echo htmlspecialchars($categoria['nombre']); ?>
        </option>
    <?php endforeach; ?>
</select>

    <label for="f-imagen">URL de la Imagen:</label>
    <input type="text" name="imagen" id="f-imagen" required>


        <input type="hidden" name="agregar_juego" value="1">
        <button type="submit">Agregar</button>
        <button type="button" onclick="document.getElementById('agregarJuegoDialog').close();">Cancelar</button>
    </form>
    </dialog>

<?php include_once(__DIR__ . '/../../components/footer/index.php'); ?>
</body>
</html>