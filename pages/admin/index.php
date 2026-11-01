<?php include_once(__DIR__ . '/../../config/database.php'); ?>
<?php require_once __DIR__ . '/../../config/base_url.php'; ?>
<?php require_once __DIR__ . '/../../config/flash.php'; ?>

<?php $sql_categorias = "SELECT * FROM categorias";?>
<?php $resultado_categorias = $conexion->query($sql_categorias);?>

<?php $sql_juegos = "SELECT * FROM juegos";?>
<?php $resultado_juegos = $conexion->query($sql_juegos);?>

<?php $sql_borrar_juego = "DELETE FROM juegos WHERE id = ?";?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_juego_id'])) {
    $juego_id = (int) $_POST['borrar_juego_id'];

    try {
        $stmt = $conexion->prepare($sql_borrar_juego);
        $stmt->bind_param('i', $juego_id);
        $stmt->execute();
        $filas_afectadas = $stmt->affected_rows;
        $stmt->close();

        if ($filas_afectadas > 0) {
            set_flash('exito', 'Juego eliminado correctamente.');
        } else {
            set_flash('error', 'El juego que intentas eliminar no existe.');
        }
    } catch (mysqli_sql_exception $e) {
        error_log('Error al eliminar juego: ' . $e->getMessage());
        set_flash('error', 'Error al eliminar el juego.');
    }

    header("Location: " . BASE_URL . "/pages/admin/index.php");
    exit();
}?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_juego'])) {
    $id = (int) ($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = (float) ($_POST['precio'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $categoria_id = (int) ($_POST['categoria_id'] ?? 0);
    $imagen = trim($_POST['imagen'] ?? '');

    $errores = [];
    if (empty($nombre) || mb_strlen($nombre) > 100) {
        $errores[] = 'El nombre es obligatorio (máximo 100 caracteres).';
    }
    if (empty($descripcion)) {
        $errores[] = 'La descripción es obligatoria.';
    }
    if ($precio < 0) {
        $errores[] = 'El precio no puede ser negativo.';
    }
    if ($stock < 0) {
        $errores[] = 'El stock no puede ser negativo.';
    }
    if (empty($imagen)) {
        $errores[] = 'La imagen es obligatoria.';
    }

    try {
        $stmt = $conexion->prepare("SELECT id FROM categorias WHERE id = ?");
        $stmt->bind_param('i', $categoria_id);
        $stmt->execute();
        $categoria_existe = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if (!$categoria_existe) {
            $errores[] = 'La categoría seleccionada no es válida.';
        }

        if (!empty($errores)) {
            set_flash('error', implode(' ', $errores));
        } elseif ($id > 0) {
            $sql_editar_juego = "UPDATE juegos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql_editar_juego);
            $stmt->bind_param('ssdiisi', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen, $id);
            $stmt->execute();
            $stmt->close();
            set_flash('exito', 'Juego editado correctamente.');
        } else {
            $sql_agregar_juego = "INSERT INTO juegos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql_agregar_juego);
            $stmt->bind_param('ssdiis', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen);
            $stmt->execute();
            $stmt->close();
            set_flash('exito', 'Juego agregado correctamente.');
        }
    } catch (mysqli_sql_exception $e) {
        error_log('Error al guardar juego: ' . $e->getMessage());
        set_flash('error', 'Error al guardar el juego.');
    }

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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/admin-card/styles.css">
    <script src="<?php echo BASE_URL; ?>/pages/admin/script.js" defer></script>

</head>

<body>
<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>

<?php $flash = get_flash(); ?>
<?php if ($flash): ?>
    <div class="flash flash-<?php echo htmlspecialchars($flash['tipo']); ?>">
        <?php echo htmlspecialchars($flash['mensaje']); ?>
    </div>
<?php endif; ?>
<button class="nuevo" type="button" onclick="abrirModal()">+ Nuevo juego</button>

<section>
    <div class="juegos-destacados">
        <?php foreach ($resultado_juegos as $juego): ?>
            <?php include(__DIR__ . '/../../components/admin-card/index.php'); ?>
        <?php endforeach; ?>
    </div>
</section>


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


        <input type="hidden" name="guardar_juego" value="1">
        <button type="submit">Guardar</button>
        <button type="button" onclick="document.getElementById('agregarJuegoDialog').close();">Cancelar</button>
    </form>
    </dialog>

<?php include_once(__DIR__ . '/../../components/footer/index.php'); ?>
</body>
</html>