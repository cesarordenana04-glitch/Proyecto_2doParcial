function abrirModal() {
    document.getElementById('modalPaciente').classList.add('active');
}

function cerrarModal() {
    document.getElementById('modalPaciente').classList.remove('active');
}

function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro de eliminar este paciente? Esta acción no se puede deshacer.")) {
        window.location.href = URL_BASE + "index.php?url=pacientes/eliminar&id=" + id;
    }
}

function abrirModalEditar(paciente) {
    document.getElementById('edit_id').value = paciente.id;
    document.getElementById('edit_cedula').value = paciente.cedula_identidad;
    document.getElementById('edit_nombre').value = paciente.nombre;
    document.getElementById('edit_apellido').value = paciente.apellido;
    document.getElementById('edit_fecha_nacimiento').value = paciente.fecha_nacimiento;
    document.getElementById('edit_telefono').value = paciente.telefono;
    document.getElementById('edit_correo').value = paciente.correo;

    document.getElementById('modalEditarPaciente').classList.add('active');
}

function cerrarModalEditar() {
    document.getElementById('modalEditarPaciente').classList.remove('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorPacientes');

    if (buscador) {
        buscador.addEventListener('input', function() {
            let textoBusqueda = this.value.toLowerCase();
            let filas = document.querySelectorAll('.fila-paciente');

            filas.forEach(function(fila) {
                let nombre = fila.cells[0].textContent.toLowerCase();
                let cedula = fila.cells[1].textContent.toLowerCase();

                if (nombre.includes(textoBusqueda) || cedula.includes(textoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
});