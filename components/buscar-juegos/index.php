
<?php
$buscar_nombre = trim($buscar_nombre ?? $_GET['buscar_por_nombre'] ?? '');
$categoria_activa = (int) ($_GET['categoria'] ?? 0);
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/buscar-juegos/styles.css">
<form action="" method="GET" class="buscador">
    <label for="buscar_por_nombre">Buscar por nombre:</label>
    <input type="text" name="buscar_por_nombre" id="buscar_por_nombre" placeholder="Buscar..."
           value="<?php echo htmlspecialchars($buscar_nombre); ?>">
    <?php if ($categoria_activa > 0): ?>
        <input type="hidden" name="categoria" value="<?php echo $categoria_activa; ?>">
    <?php endif; ?>
    <button type="submit">Buscar</button>
</form>
