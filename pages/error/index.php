<?php require_once __DIR__ . '/../../config/base_url.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina no encontrada</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/error/styles.css">
</head>


<body>
<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>


    <div class="error-container">
    <img src="<?php echo BASE_URL; ?>/assets/error.png" alt="Error 404" class="error-image" heigth="300px" width="300px">
    <h1>Pagina no encontrada</h1>
    <p>Ups! parece que la página que buscas no existe.</p>
    <button onclick="window.location.href='<?php echo BASE_URL; ?>/'">Volver al inicio</button>

</div>


<?php include_once(__DIR__ . '/../../components/footer/index.php'); ?>
</body>
</html>