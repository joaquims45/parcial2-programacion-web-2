<link rel="stylesheet" href="<?php echo BASE_URL; ?>/components/admin-card/styles.css">
<section> 

<div class="juegos-destacados">
    <?php foreach ($resultado_juegos as $juego): ?>
        <div class="juego">
            <img src="<?php echo htmlspecialchars(url_imagen($juego['imagen'])); ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>">
            <h3><?php echo $juego['nombre']; ?></h3>
            <p><?php echo $juego['descripcion']; ?></p>
             <div class="acciones">
        <button class="editar" type="button"
                onclick='abrirModal(<?php echo json_encode($juego, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>
            Editar
        </button>
                <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que deseas borrar este juego?');">
                    <input type="hidden" name="borrar_juego_id" value="<?php echo $juego['id']; ?>">
                    <button class="borrar" type="submit">Borrar</button>
                </form>
        </div>
    </div>
   
    <?php endforeach; ?>
</section>
    </div>