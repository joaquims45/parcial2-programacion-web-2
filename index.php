<?php require_once __DIR__ . '/config/base_url.php'; ?>
<?php require_once __DIR__ . '/config/database.php'; ?>

<?php $sql= "SELECT * FROM juegos WHERE destacado = 1"; ?>
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

        <div class="juegos-destacados">
        <?php while ($juego = $resultado_juegos->fetch_assoc()): ?>

        <?php include("components/juegos-card/index.php"); ?>
        
        <?php endwhile; ?>
        </div>
        </section>

        <h2 class="titulo-juegos">Sobre nosotros</h2>

        <section class="beneficios">
            <div class="beneficio-card">
                <img src="<?php echo BASE_URL; ?>/assets/secure-buy.png" alt="Compra segura" width="50px" height="50px">
                <h3>Compra segura</h3>
                <p>Garantizamos la seguridad de tus datos y transacciones.</p>
            </div>
            
            <div class="beneficio-card">
                <img src="<?php echo BASE_URL; ?>/assets/fast-delivery.png" alt="Entrega instantanea" width="50px" height="50px">
                <h3>Entrega instantanea</h3>
                <p>Recibe tus juegos de manera rápida y eficiente.</p>
            </div>

            <div class="beneficio-card">
                <img src="<?php echo BASE_URL; ?>/assets/support.png" alt="Soporte al cliente" width="50px" height="50px">
                <h3>Soporte al cliente</h3>
                <p>Estamos aquí para ayudarte en cualquier momento.</p>
            </div>

            <div class="beneficio-card">
                <img src="<?php echo BASE_URL; ?>/assets/discount.png" alt="Descuentos y promociones" width="50px" height="50px">
                <h3>Descuentos y promociones</h3>
                <p>Aprovecha nuestras ofertas especiales y ahorra en tus compras.</p>
        </section>

    </main>
                        <?php include_once("components/footer/index.php"); ?>

</body>
</html>



