<link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/juegos-card/styles.css">
<section> 

<div class="juegos-destacados">
    <?php foreach ($resultado_juegos as $juego): ?>
        <div class="juego">
            <img src="<?php echo $juego['imagen']; ?>" alt="<?php echo $juego['nombre']; ?>">
            <h3><?php echo $juego['nombre']; ?></h3>
            <p><?php echo $juego['descripcion']; ?></p>
        </div>
    <?php endforeach; ?>
</section>
    </div>