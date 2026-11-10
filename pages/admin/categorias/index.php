<?php
require_once __DIR__ . '/../../../config/base_url.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../config/flash.php';

$url_categorias = BASE_URL . '/pages/admin/categorias/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_categoria_id'])) {
    $categoria_id = (int) $_POST['borrar_categoria_id'];

    if ($categoria_id <= 0) {
        set_flash('error', 'ID de categoría inválido.');
    } else {
        try {
            $stmt = $conexion->prepare("SELECT COUNT(*) FROM juegos WHERE categoria_id = ?");
            $stmt->bind_param('i', $categoria_id);
            $stmt->execute();
            $stmt->bind_result($cantidad_juegos);
            $stmt->fetch();
            $stmt->close();

            if ($cantidad_juegos > 0) {
                set_flash('error', 'No se puede eliminar la categoría porque tiene ' . $cantidad_juegos . ' juego(s) asociado(s).');
            } else {
                $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
                $stmt->bind_param('i', $categoria_id);
                $stmt->execute();
                $filas_afectadas = $stmt->affected_rows;
                $stmt->close();

                if ($filas_afectadas > 0) {
                    set_flash('exito', 'Categoría eliminada correctamente.');
                } else {
                    set_flash('error', 'La categoría que intentas eliminar no existe.');
                }
            }
        } catch (mysqli_sql_exception $e) {
            error_log('Error al eliminar categoría: ' . $e->getMessage());
            set_flash('error', 'Error al eliminar la categoría.');
        }
    }

    header('Location: ' . $url_categorias);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_categoria_nombre'])) {
    $nombre_categoria = trim($_POST['nueva_categoria_nombre']);

    if ($nombre_categoria === '' || mb_strlen($nombre_categoria) > 50) {
        set_flash('error', 'El nombre es obligatorio (máximo 50 caracteres).');
    } else {
        try {
            $stmt = $conexion->prepare("INSERT INTO categorias (nombre) VALUES (?)");
            $stmt->bind_param('s', $nombre_categoria);
            $stmt->execute();
            $stmt->close();
            set_flash('exito', 'Categoría agregada correctamente.');
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                set_flash('error', 'Ya existe una categoría con ese nombre.');
            } else {
                error_log('Error al guardar categoría: ' . $e->getMessage());
                set_flash('error', 'Error al guardar la categoría.');
            }
        }
    }

    header('Location: ' . $url_categorias);
    exit();
}

$buscar_nombre = trim($_GET['buscar_por_nombre'] ?? '');

try {
    if ($buscar_nombre !== '') {
        $termino_busqueda = '%' . $buscar_nombre . '%';
        $stmt = $conexion->prepare("SELECT * FROM categorias WHERE nombre LIKE ? ORDER BY id");
        $stmt->bind_param('s', $termino_busqueda);
    } else {
        $stmt = $conexion->prepare("SELECT * FROM categorias ORDER BY id");
    }
    $stmt->execute();
    $resultado_categorias = $stmt->get_result();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log('Error al listar categorías: ' . $e->getMessage());
    set_flash('error', 'Error al listar las categorías.');
    $resultado_categorias = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/admin/styles.css?v=<?php echo filemtime(__DIR__ . '/../styles.css'); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/admin/categorias/styles.css">
    <script src="<?php echo BASE_URL; ?>/pages/admin/categorias/script.js?v=<?php echo filemtime(__DIR__ . '/script.js'); ?>" defer></script>
</head>
<body>

<?php include_once(__DIR__ . '/../../../components/header/index.php'); ?>

<div class="admin-layout">
    <?php include_once(__DIR__ . '/../../../components/admin-sidebar/index.php'); ?>

    <main class="admin-contenido">
        <?php $flash = get_flash(); ?>
        <?php if ($flash): ?>
            <div class="flash flash-<?php echo htmlspecialchars($flash['tipo']); ?>">
                <?php echo htmlspecialchars($flash['mensaje']); ?>
            </div>
        <?php endif; ?>

        <div class="admin-barra">
            <button class="nuevo" type="button" onclick="abrirModal()">+ Nueva categoría</button>
            <?php include_once(__DIR__ . '/../../../components/buscar-categoria/index.php'); ?>
        </div>

        <h1>Categorías</h1>

        <?php if ($resultado_categorias): ?>
            <?php while ($categoria = $resultado_categorias->fetch_assoc()): ?>
                <div class="categoria-card">
                    <h2><?php echo htmlspecialchars($categoria['id']); ?></h2>
                    <p><?php echo htmlspecialchars($categoria['nombre']); ?></p>
                    <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que deseas borrar esta categoría?');">
                        <input type="hidden" name="borrar_categoria_id" value="<?php echo htmlspecialchars($categoria['id']); ?>">
                        <button class="borrar" type="submit">Borrar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </main>
</div>

<dialog id="agregarCategoriaDialog">
    <form method="POST" action="" class="modal-form">
        <div class="modal-header">
            <h2 id="modal-titulo">Agregar categoría</h2>
            <button type="button" class="modal-cerrar" aria-label="Cerrar"
                    onclick="document.getElementById('agregarCategoriaDialog').close();">&times;</button>
        </div>

        <div class="campo">
            <label for="f-nueva_categoria_nombre">Nombre de la categoría</label>
            <input type="text" name="nueva_categoria_nombre" id="f-nueva_categoria_nombre" maxlength="50" required>
        </div>

        <div class="modal-acciones">
            <button type="button" class="boton-cancelar"
                    onclick="document.getElementById('agregarCategoriaDialog').close();">Cancelar</button>
            <button type="submit" class="boton-guardar">Guardar</button>
        </div>
    </form>
</dialog>

<?php include_once(__DIR__ . '/../../../components/footer/index.php'); ?>
</body>
</html>
