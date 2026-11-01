<link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/juegos-card/styles.css">

        <div class="juego">
            <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($juego['imagen']); ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>">
            <h3><?php echo htmlspecialchars($juego['nombre']); ?></h3>
            <p><?php echo htmlspecialchars($juego['descripcion']); ?></p>
        </div>
