const modal = document.getElementById('agregarJuegoDialog');

function abrirModal(juego = null) {
    document.getElementById('modal-titulo').textContent = juego ? 'Editar juego' : 'Agregar juego';
    document.getElementById('f-id').value          = juego ? juego.id : 0;
    document.getElementById('f-nombre').value      = juego ? juego.nombre : '';
    document.getElementById('f-descripcion').value = juego ? juego.descripcion : '';
    document.getElementById('f-precio').value      = juego ? juego.precio : '';
    document.getElementById('f-stock').value       = juego ? juego.stock : '';
    document.getElementById('f-imagen').value      = juego ? juego.imagen : '';
    document.getElementById('f-categoria').value   = juego ? juego.categoria_id : '';
    document.getElementById('f-destacado').checked = juego ? juego.destacado : false;
    modal.showModal();
}
