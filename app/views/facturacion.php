<?php require_once 'layouts/header.php'; ?>
<?php require_once 'layouts/sidebar.php'; ?>

<?php
/**
 * @var array $facturas 
 * @var array $estadisticas 
 * @var array $pacientes 
 * @var array $servicios
 * @var string $proximo_comprobante
 */
?>

<link rel="stylesheet" href="<?= URL_BASE ?>css/pacientes.css">
<link rel="stylesheet" href="<?= URL_BASE ?>css/facturacion.css">

<div class="page-content">

    <div class="page-header">
        <div class="page-title">
            <i class='bx bx-receipt'></i>
            <div>
                <h2>Módulo de Facturación</h2>
                <p>Emisión directa de facturas y cobro de servicios</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-orange" id="btnNuevaFactura">
                <i class='bx bx-plus'></i> Nueva Factura
            </button>
        </div>
    </div>

    <div class="indicator-cards">
        <div class="card-stat">
            <i class='bx bx-receipt' style="color: #3b82f6; background: #dbeafe;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['total_emitidas'] ?></h3>
                <p>Facturas Emitidas</p>
            </div>
        </div>
        <div class="card-stat">
            <i class='bx bx-check-circle' style="color: #10b981; background: #d1fae5;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['total_pagadas'] ?></h3>
                <p>Pagadas</p>
            </div>
        </div>
        <div class="card-stat">
            <i class='bx bx-dots-horizontal-rounded' style="color: #f59e0b; background: #fef3c7;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['total_pendientes'] ?></h3>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="card-stat">
            <i class='bx bx-calendar-event' style="color: #059669; background: #a7f3d0;"></i>
            <div class="stat-info">
                <h3>$<?= number_format($estadisticas['ingresos_hoy'], 2) ?></h3>
                <p>Ingresos Hoy</p>
            </div>
        </div>
    </div>

    <div class="form-panel" id="panelFormulario" style="display: none;">
        <div class="panel-header header-light">
            <h3><i class='bx bx-plus-circle'></i> Registrar Pago / Emitir Factura</h3>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=facturacion/guardar" method="POST" id="formFacturacion" class="panel-body">

            <input type="hidden" name="numero_comprobante" value="<?= $proximo_comprobante ?>">
            <input type="hidden" name="subtotal_oculto" id="input_subtotal_oculto" value="0">
            <input type="hidden" name="iva_oculto" id="input_iva_oculto" value="0">
            <input type="hidden" name="total_oculto" id="input_total_oculto" value="0">

            <div class="form-group grid-4" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                <div class="col" style="grid-column: span 2;">
                    <label>Paciente *</label>
                    <select name="paciente_id" id="select_paciente" required>
                        <option value="">-- Seleccione un paciente --</option>
                        <?php foreach ($pacientes as $p): ?>
                            <option value="<?= $p['id'] ?>" data-cedula="<?= $p['cedula_identidad'] ?>">
                                <?= $p['nombre'] . ' ' . $p['apellido'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label>Cédula</label>
                    <input type="text" id="input_cedula" readonly class="readonly-input">
                </div>
                <div class="col">
                    <label>Fecha de Emisión *</label>
                    <input type="date" name="fecha_emision" id="input_fecha" required>
                </div>
            </div>

            <h4 class="section-title" style="margin-top: 24px;"><i class='bx bx-list-ul'></i> Detalle de Servicios</h4>
            <div id="contenedor-items" class="items-container">
            </div>

            <button type="button" class="btn-outline-dashed" id="btnAgregarItem" style="margin-bottom: 24px;">
                <i class='bx bx-plus-circle'></i> Añadir Servicio
            </button>

            <div class="form-group row totals-display-row" style="background-color: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; align-items: flex-end;">
                <div class="col">
                    <label>Forma de Pago *</label>
                    <select name="forma_pago" required>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                        <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>
                <div class="col">
                    <label>Subtotal ($)</label>
                    <input type="text" id="display_subtotal" class="readonly-input text-right" readonly value="0.00">
                </div>
                <div class="col">
                    <label>IVA (15%)</label>
                    <input type="text" id="display_iva" class="readonly-input text-right" readonly value="0.00">
                </div>
                <div class="col">
                    <label>Total a Cobrar</label>
                    <input type="text" id="display_total" class="readonly-input text-right total-input" readonly value="$0.00">
                </div>
            </div>

            <div class="panel-footer bg-transparent p-0 mt-3" style="display: flex; gap: 12px; border: none; padding-top: 16px;">
                <button type="submit" class="btn-orange"><i class='bx bx-check-shield'></i> Emitir Factura</button>
                <button type="button" class="btn-secondary" onclick="cerrarPanelFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <div style="margin-bottom: 20px; display: flex; align-items: center; background: #fff; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <i class='bx bx-search' style="font-size: 1.2rem; color: #64748b; margin-right: 10px;"></i>
        <input type="text" id="buscadorFacturas" placeholder="Buscar factura por número de cédula..." style="border: none; outline: none; width: 100%; font-size: 0.95rem; color: #1e293b;">
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>N° COMP.</th>
                    <th>PACIENTE</th>
                    <th>FECHA</th>
                    <th>FORMA PAGO</th>
                    <th>SUBTOTAL</th>
                    <th>IVA</th>
                    <th>TOTAL</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($facturas)): ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">No hay facturas registradas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($facturas as $f): ?>
                        <tr class="fila-factura">
                            <td><strong><?= $f['numero_comprobante'] ?></strong></td>
                            <td>
                                <?= $f['paciente_nombre'] . ' ' . $f['paciente_apellido'] ?>
                                <br><small class="ci-text" style="color: #64748b;">CI: <?= $f['cedula_identidad'] ?></small>
                            </td>
                            <td><?= $f['fecha_emision'] ?></td>
                            <td><?= $f['forma_pago'] ?></td>
                            <td>$<?= number_format($f['subtotal'], 2) ?></td>
                            <td>$<?= number_format($f['iva'], 2) ?></td>
                            <td><strong>$<?= number_format($f['total'], 2) ?></strong></td>
                            <td>
                                <?php
                                $claseEstado = 'badge-success';
                                if ($f['estado'] === 'Pendiente') $claseEstado = 'badge-warning';
                                if ($f['estado'] === 'Anulada') $claseEstado = 'badge-danger';
                                ?>
                                <span class="badge <?= $claseEstado ?>"><?= $f['estado'] ?></span>
                            </td>
                            <td class="actions-cell">
                                <button class="btn-icon edit" onclick='editarFactura(<?= htmlspecialchars(json_encode($f), ENT_QUOTES, "UTF-8") ?>)' title="Editar">
                                    <i class='bx bx-edit-alt'></i>
                                </button>

                                <?php if ($f['estado'] !== 'Anulada'): ?>
                                    <button class="btn-icon cancel" onclick="confirmarAnulacion(<?= $f['id'] ?>)" title="Anular">
                                        <i class='bx bx-block'></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<template id="fila-item-template">
    <div class="dynamic-row">
        <select name="item_servicio_id[]" class="input-servicio" required>
            <option value="">-- Servicio / Ítem --</option>
            <?php foreach ($servicios as $s): ?>
                <option value="<?= $s['id'] ?>" data-precio="<?= $s['precio'] ?>">
                    <?= $s['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="item_descripcion[]" class="input-descripcion" placeholder="Descripción adicional (Opcional)" required>

        <div class="price-input-group">
            <span class="currency-symbol">$</span>
            <input type="number" step="0.01" min="0" name="item_precio[]" class="input-precio" placeholder="0.00" required>
        </div>

        <button type="button" class="btn-remove-row" title="Eliminar fila"><i class='bx bx-trash'></i></button>
    </div>
</template>

<script>
    const URL_BASE = "<?= URL_BASE ?>";
</script>
<script src="<?= URL_BASE ?>js/facturacion.js"></script>
<?php require_once 'layouts/footer.php'; ?>