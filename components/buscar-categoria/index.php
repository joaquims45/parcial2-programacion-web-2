<?php
$buscar_nombre = trim($buscar_nombre ?? $_GET['buscar_por_nombre'] ?? ''); ?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/buscar-categoria/styles.css">
<form action="" method="GET" class="buscador">
    <label for="buscar_por_nombre">Buscar por nombre:</label>
    <input type="text" name="buscar_por_nombre" id="buscar_por_nombre" placeholder="Buscar..."
           value="<?php echo htmlspecialchars($buscar_nombre); ?>">
    <button type="submit">Buscar</button>
</form>
