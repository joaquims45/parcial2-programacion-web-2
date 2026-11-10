const modal = document.getElementById('agregarCategoriaDialog');

function abrirModal(categoria = null) {
    document.getElementById('f-nueva_categoria_nombre').value = '';
    modal.showModal();
}
