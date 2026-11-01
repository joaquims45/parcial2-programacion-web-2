<?php require_once __DIR__ . '/config/base_url.php'; ?>
<?php require_once __DIR__ . '/config/database.php'; ?>

<?php $sql= "SELECT * FROM juegos LIMIT 4";?>
<?php $resultado_juegos = $conexion->query($sql);?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inicio</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles.css">
    </head>
    
 
    <body>
        <?php include_once("components/header/index.php"); ?>

    <main> 
        <section>
            <img src="<?php echo BASE_URL; ?>/assets/banner.png" alt="Banner" width="100%" height="100%">
        </section>

        <section> 

        <h2 class="titulo-juegos">Juegos destacados</h2>
        <?php while ($juego = $resultado_juegos->fetch_assoc()): ?>

        <?php include_once("components/juegos-card/index.php"); ?>
        
            <?php endwhile; ?>
        </section>

    </main>
                        <?php include_once("components/footer/index.php"); ?>

</body>
</html>



