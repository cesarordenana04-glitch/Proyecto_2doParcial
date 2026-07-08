// /public/js/facturacion.js

document.addEventListener('DOMContentLoaded', function() {
    
    const panelFormulario = document.getElementById('panelFormulario');
    const formFacturacion = document.getElementById('formFacturacion');
    const contenedorItems = document.getElementById('contenedor-items');
    const templateFila = document.getElementById('fila-item-template');
    const btnNuevaFactura = document.getElementById('btnNuevaFactura');
    const btnAgregarItem = document.getElementById('btnAgregarItem');

    // Fecha inicial
    const inputFecha = document.getElementById('input_fecha');
    if(inputFecha) inputFecha.value = new Date().toISOString().split('T')[0];

    // Clic en "Nueva Factura"
    if(btnNuevaFactura) {
        btnNuevaFactura.addEventListener('click', () => {
            panelFormulario.style.display = 'block';    
            asegurarFilaInicial();
            formFacturacion.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Cerrar panel
    window.cerrarPanelFormulario = function() {
        panelFormulario.style.display = 'none';
        formFacturacion.reset();
        contenedorItems.innerHTML = '';
    };

    // Lógica de Filas
    function agregarFila() {
        const nuevaFila = templateFila.content.cloneNode(true);
        const selectServicio = nuevaFila.querySelector('.input-servicio');
        const inputPrecio = nuevaFila.querySelector('.input-precio');
        const btnEliminar = nuevaFila.querySelector('.btn-remove-row');

        selectServicio.addEventListener('change', function() {
            const opcionSeleccionada = this.options[this.selectedIndex];
            const precioBase = opcionSeleccionada.getAttribute('data-precio');
            
            if (precioBase && precioBase > 0) {
                inputPrecio.value = parseFloat(precioBase).toFixed(2);
            }
            calcularTotales();
        });

        inputPrecio.addEventListener('input', calcularTotales);

        btnEliminar.addEventListener('click', function() {
            this.closest('.dynamic-row').remove();
            calcularTotales();
        });

        contenedorItems.appendChild(nuevaFila);
    }

    if(btnAgregarItem) btnAgregarItem.addEventListener('click', agregarFila);

    function asegurarFilaInicial() {
        if (contenedorItems.children.length === 0) {
            agregarFila();
            calcularTotales();
        }
    }

    // Calcular en tiempo real
    function calcularTotales() {
        let subtotal = 0;
        
        document.querySelectorAll('.input-precio').forEach(input => {
            const valor = parseFloat(input.value);
            if (!isNaN(valor)) subtotal += valor;
        });

        const iva = subtotal * 0.15;
        const total = subtotal + iva;

        // Mostrar visuales
        document.getElementById('display_subtotal').value = subtotal.toFixed(2);
        document.getElementById('display_iva').value = iva.toFixed(2);
        document.getElementById('display_total').value = '$' + total.toFixed(2);

        // Guardar en ocultos para PHP
        document.getElementById('input_subtotal_oculto').value = subtotal.toFixed(2);
        document.getElementById('input_iva_oculto').value = iva.toFixed(2);
        document.getElementById('input_total_oculto').value = total.toFixed(2);
    }

    // Autocompletado de cédula
    const selectPaciente = document.getElementById('select_paciente');
    const inputCedula = document.getElementById('input_cedula');
    
    if(selectPaciente && inputCedula) {
        selectPaciente.addEventListener('change', function() {
            const opcion = this.options[this.selectedIndex];
            inputCedula.value = opcion.getAttribute('data-cedula') || '';
        });
    }

    // Anular
    window.confirmarAnulacion = function(id) {
        if (confirm("¿Estás seguro de que deseas ANULAR esta factura?")) {
            window.location.href = URL_BASE + "index.php?url=facturacion/anular&id=" + id;
        }
    };

    window.editarFactura = function(factura) {
        const panelFormulario = document.getElementById('panelFormulario');
        panelFormulario.style.display = 'block';

        document.getElementById('select_paciente').value = factura.paciente_id;
        document.getElementById('select_paciente').dispatchEvent(new Event('change'));

        document.getElementById('input_fecha').value = factura.fecha_emision;
        document.querySelector('select[name="forma_pago"]').value = factura.forma_pago;

        document.getElementById('display_subtotal').value = parseFloat(factura.subtotal).toFixed(2);
        document.getElementById('display_iva').value = parseFloat(factura.iva).toFixed(2);
        document.getElementById('display_total').value = '$' + parseFloat(factura.total).toFixed(2);

        document.getElementById('input_subtotal_oculto').value = factura.subtotal;
        document.getElementById('input_iva_oculto').value = factura.iva;
        document.getElementById('input_total_oculto').value = factura.total;

        document.getElementById('formFacturacion').scrollIntoView({ behavior: 'smooth' });
    };

    const buscador = document.getElementById('buscadorFacturas');
    
    if (buscador) {
        buscador.addEventListener('input', function() {
            const textoBusqueda = this.value.toLowerCase().trim();
            const filas = document.querySelectorAll('.fila-factura');

            filas.forEach(fila => {
                const cedula = fila.querySelector('.ci-text').textContent.toLowerCase();
                
                if (cedula.includes(textoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
});