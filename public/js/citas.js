function abrirModal() {
    document.getElementById('modalCita').classList.add('active');
}

function cerrarModal() {
    document.getElementById('modalCita').classList.remove('active');
}

function abrirModalEditar(cita) {
    document.getElementById('edit_cita_id').value = cita.id;
    document.getElementById('edit_medico_id').value = cita.medico_id;
    document.getElementById('edit_fecha').value = cita.fecha;
    document.getElementById('edit_hora').value = cita.hora;
    document.getElementById('edit_motivo').value = cita.motivo;
    document.getElementById('edit_estado').value = cita.estado;

    document.getElementById('modalEditarCita').classList.add('active');
}

function cerrarModalEditar() {
    document.getElementById('modalEditarCita').classList.remove('active');
}

function confirmarCancelacion(id) {
    if (confirm("¿Estás seguro de que deseas marcar esta cita como CANCELADA?")) {
        window.location.href = URL_BASE + "index.php?url=citas/cancelar&id=" + id;
    }
}

function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro de eliminar esta cita? Esta acción no se puede revertir.")) {
        window.location.href = URL_BASE + "index.php?url=citas/eliminar&id=" + id;
    }
}