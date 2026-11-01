<div class="juego">
            <img src="<?php echo htmlspecialchars(url_imagen($juego['imagen'])); ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>">
            <h3><?php echo htmlspecialchars($juego['nombre']); ?></h3>
            <p><?php echo htmlspecialchars($juego['descripcion']); ?></p>
             <div class="acciones">
        <button class="editar" type="button"
                onclick='abrirModal(<?php echo json_encode($juego, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP); ?>)'>
            Editar
        </button>
                <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que deseas borrar este juego?');">
                    <input type="hidden" name="borrar_juego_id" value="<?php echo htmlspecialchars($juego['id']); ?>">
                    <button class="borrar" type="submit">Borrar</button>
                </form>
        </div>
</div>
