
document.addEventListener('DOMContentLoaded', function() {
    
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    const btnOcultar = document.querySelectorAll('.toggle-hide-btn');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            if (e.target.closest('button')) return; 
            
            const card = this.closest('.accordion-card');
            
            // Opcional: Cerrar los demás al abrir uno (Descomenta las siguientes 3 líneas si lo deseas)
            // document.querySelectorAll('.accordion-card').forEach(c => {
            //    if (c !== card) c.classList.remove('active');
            // });

            card.classList.toggle('active');
        });
    });

    // Al hacer clic en el botón "Ocultar"
    btnOcultar.forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.accordion-card').classList.remove('active');
        });
    });


    //FORMULARIO
    const panelNueva = document.getElementById('panelNuevaConsulta');
    const panelEditar = document.getElementById('panelEditarConsulta');

    // Botones de Apertura
    const btnNueva = document.getElementById('btnNuevaConsulta');

    // Botones de Cierre
    const btnCerrarNueva = document.getElementById('btnCerrarNuevaConsulta');
    const btnCancelarNueva = document.getElementById('btnCancelarNueva');
    const btnCerrarEditar = document.getElementById('btnCerrarEditarConsulta');
    const btnCancelarEditar = document.getElementById('btnCancelarEditar');

    function ocultarPaneles() {
        if(panelNueva) panelNueva.style.display = 'none';
        if(panelEditar) panelEditar.style.display = 'none';
    }

    //Panel nueva Consulta (Muestra formulario)
    if(btnNueva) {
        btnNueva.addEventListener('click', () => {
            ocultarPaneles();
            panelNueva.style.display = 'block';
            panelNueva.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Eventos de cierre
    [btnCerrarNueva, btnCancelarNueva, btnCerrarEditar, btnCancelarEditar].forEach(btn => {
        if(btn) {
            btn.addEventListener('click', () => {
                ocultarPaneles();
            });
        }
    });


    //Autocompletar con cedula
    const selectPaciente = document.getElementById('select_paciente_nuevo');
    const inputCedula = document.getElementById('input_cedula_nuevo');
    
    if(selectPaciente && inputCedula) {
        selectPaciente.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cedula = selectedOption.getAttribute('data-cedula') || '';
            inputCedula.value = cedula;
        });
    }


    //Buscador
    const buscador = document.getElementById('buscadorHistorial');
    
    if (buscador) {
        buscador.addEventListener('input', function() {
            let textoBusqueda = this.value.toLowerCase();
            let filas = document.querySelectorAll('.fila-historial');

            filas.forEach(function(fila) {
                let nombre = fila.querySelector('.name-text').textContent.toLowerCase();
                let cedula = fila.querySelector('.ci-text').textContent.toLowerCase();

                if (nombre.includes(textoBusqueda) || cedula.includes(textoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
});


//Funcion de editar y eliminar

// Se ejecuta al hacer clic en "Editar" dentro de un expediente
function abrirEdicionHistorial(historial) {
    // 1. Ocultamos el panel de Nueva si estaba abierto
    document.getElementById('panelNuevaConsulta').style.display = 'none';
    
    // 2. Llenamos los inputs principales
    document.getElementById('edit_historial_id').value = historial.id;
    document.getElementById('edit_paciente_id').value = historial.paciente_id;
    document.getElementById('edit_medico_id').value = historial.medico_id;
    document.getElementById('edit_fecha').value = historial.fecha;
    
    // 3. Llenamos los Signos Vitales
    document.getElementById('edit_presion').value = historial.presion_arterial;
    document.getElementById('edit_fc').value = historial.frecuencia_cardiaca;
    document.getElementById('edit_temp').value = historial.temperatura;
    document.getElementById('edit_sat').value = historial.saturacion_o2;
    document.getElementById('edit_peso').value = historial.peso;
    document.getElementById('edit_talla').value = historial.talla;
    
    // 4. Llenamos los Textos Médicos
    document.getElementById('edit_antecedentes').value = historial.antecedentes_personales;
    document.getElementById('edit_motivo').value = historial.motivo_consulta;
    document.getElementById('edit_diagnostico').value = historial.diagnostico;
    document.getElementById('edit_tratamiento').value = historial.tratamiento_receta;
    document.getElementById('edit_observaciones').value = historial.observaciones;

    // 5. Mostramos el panel de edición
    const panelEditar = document.getElementById('panelEditarConsulta');
    panelEditar.style.display = 'block';
    panelEditar.scrollIntoView({ behavior: 'smooth' }); // Desliza la pantalla hacia el formulario
}

// Se ejecuta al hacer clic en "Eliminar"
function confirmarEliminacionHistorial(id) {
    if (confirm("¿Estás seguro de eliminar este registro clínico? Se borrarán también los signos vitales asociados.\n\nEsta acción NO se puede deshacer.")) {
        window.location.href = URL_BASE + "index.php?url=historial/eliminar&id=" + id;
    }
}