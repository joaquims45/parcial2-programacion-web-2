<?php include_once(__DIR__ . '/../../config/database.php'); ?>
<?php require_once __DIR__ . '/../../config/base_url.php'; ?>
<?php require_once __DIR__ . '/../../config/flash.php'; ?>

<?php $sql_categorias = "SELECT * FROM categorias";?>
<?php $resultado_categorias = $conexion->query($sql_categorias);?>

<?php
if (isset($_GET['buscar_por_nombre'])) {
    $buscar_nombre = trim($_GET['buscar_por_nombre']);
    setcookie('ultimo_filtro', $buscar_nombre, [
        'expires' => time() + 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
} else {
    $buscar_nombre = trim($_COOKIE['ultimo_filtro'] ?? '');
}

try {
    if ($buscar_nombre !== '') {
        $termino_busqueda = '%' . $buscar_nombre . '%';
        $stmt = $conexion->prepare("SELECT * FROM juegos WHERE nombre LIKE ? ORDER BY id");
        $stmt->bind_param('s', $termino_busqueda);
    } else {
        $stmt = $conexion->prepare("SELECT * FROM juegos ORDER BY id");
    }
    $stmt->execute();
    $resultado_juegos = $stmt->get_result();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log('Error al listar juegos: ' . $e->getMessage());
    set_flash('error', 'Error al listar los juegos.');
    $resultado_juegos = [];
}
?>

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
    $destacado = isset($_POST['destacado']) ? 1 : 0;
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
            $sql_editar_juego = "UPDATE juegos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen = ?, destacado = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql_editar_juego);
            $stmt->bind_param('ssdiisii', $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen, $destacado, $id);
            $stmt->execute();
            $stmt->close();
            set_flash('exito', 'Juego editado correctamente.');
        } else {
            $sql_agregar_juego = "INSERT INTO juegos (nombre, descripcion, precio, stock, categoria_id, imagen, destacado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql_agregar_juego);
            $stmt->bind_param('ssdiisi',$nombre, $descripcion, $precio, $stock, $categoria_id, $imagen, $destacado);
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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/admin/styles.css?v=<?php echo filemtime(__DIR__ . '/styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/admin-card/styles.css">
    <script src="<?php echo BASE_URL; ?>/pages/admin/script.js?v=<?php echo filemtime(__DIR__ . '/script.js'); ?>" defer></script>

</head>

<body>

<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>

<div class="admin-layout">
<?php include_once(__DIR__ . '/../../components/admin-sidebar/index.php'); ?>
<hr> </hr>
<main class="admin-contenido">
<?php $flash = get_flash(); ?>
<?php if ($flash): ?>
    <div class="flash flash-<?php echo htmlspecialchars($flash['tipo']); ?>">
        <?php echo htmlspecialchars($flash['mensaje']); ?>
    </div>
<?php endif; ?>
<div class="admin-barra">
    <button class="nuevo" type="button" onclick="abrirModal()">+ Nuevo juego</button>
    <?php include_once(__DIR__ . '/../../components/buscar-juegos/index.php'); ?>
</div>

<section>
    <div class="juegos-destacados">
        <?php while ($juego = $resultado_juegos->fetch_assoc()): ?>
            <?php include(__DIR__ . '/../../components/admin-card/index.php'); ?>
        <?php endwhile; ?>
    </div>
</section>
</main>
</div>


<dialog id="agregarJuegoDialog">
    <form method="POST" action="" class="modal-form">
        <div class="modal-header">
            <h2 id="modal-titulo">Agregar juego</h2>
            <button type="button" class="modal-cerrar" aria-label="Cerrar"
                    onclick="document.getElementById('agregarJuegoDialog').close();">&times;</button>
        </div>

        <input type="hidden" name="id" id="f-id" value="0">
        <input type="hidden" name="guardar_juego" value="1">

        <div class="campo">
            <label for="f-nombre">Nombre</label>
            <input type="text" name="nombre" id="f-nombre" maxlength="100" required>
        </div>

        <div class="campo">
            <label for="f-descripcion">Descripción</label>
            <textarea name="descripcion" id="f-descripcion" rows="4" required></textarea>
        </div>

        <div class="fila">
            <div class="campo">
                <label for="f-precio">Precio</label>
                <input type="number" step="0.01" min="0" name="precio" id="f-precio" required>
            </div>
            <div class="campo">
                <label for="f-stock">Stock</label>
                <input type="number" min="0" name="stock" id="f-stock" required>
            </div>
        </div>

        <div class="campo">
            <label for="f-categoria">Categoría</label>
            <select name="categoria_id" id="f-categoria" required>
                <?php foreach ($resultado_categorias as $categoria): ?>
                    <option value="<?php echo htmlspecialchars($categoria['id']); ?>">
                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label for="f-imagen">Imagen</label>
            <input type="text" name="imagen" id="f-imagen" required>
        </div>

        <label class="check" for="f-destacado">
            <input type="checkbox" name="destacado" id="f-destacado">
            Destacado
        </label>

        <div class="modal-acciones">
            <button type="button" class="boton-cancelar"
                    onclick="document.getElementById('agregarJuegoDialog').close();">Cancelar</button>
            <button type="submit" class="boton-guardar">Guardar</button>
        </div>
    </form>
</dialog>

<?php include_once(__DIR__ . '/../../components/footer/index.php'); ?>
</body>
</html>