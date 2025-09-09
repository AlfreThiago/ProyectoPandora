function mostrarDescripcion(select) {
    let descripcion = select.options[select.selectedIndex].getAttribute('data-descripcion');
    document.getElementById('descripcion').value = descripcion || "";
}
 