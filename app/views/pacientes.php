<?php require_once 'layouts/header.php'; ?>
<?php require_once 'layouts/sidebar.php'; ?>

<?php
/**
 * @var int $totalPacientes 
 * @var array $pacientes 
 */
?>

<link rel="stylesheet" href="<?= URL_BASE ?>css/pacientes.css">

<div class="page-content">

    <div class="page-header">
        <div class="page-title">
            <i class='bx bx-group'></i>
            <div>
                <h2>Gestión de Pacientes</h2>
                <p>Registro y control de pacientes del hospital</p>
            </div>
        </div>
        <button class="btn-primary" onclick="abrirModal()">
            <i class='bx bx-user-plus'></i> Nuevo Paciente
        </button>
    </div>

    <div class="indicator-cards">
        <div class="card-stat">
            <i class='bx bx-group'></i>
            <div class="stat-info">
                <h3><?= $totalPacientes ?></h3>
                <p>Total Pacientes</p>
            </div>
        </div>
    </div>

    <div class="search-bar">
        <i class='bx bx-search'></i>
        <input type="text" id="buscadorPacientes" placeholder="Buscar por nombre o cédula...">
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>CÉDULA</th>
                    <th>TELÉFONO</th>
                    <th>CORREO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pacientes)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No hay pacientes registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pacientes as $p): ?>
                        <tr class="fila-paciente">
                            <td>
                                <div class="patient-cell">
                                    <div class="patient-avatar"><?= substr($p['nombre'], 0, 1) . substr($p['apellido'], 0, 1) ?></div>
                                    <div>
                                        <strong><?= $p['nombre'] . ' ' . $p['apellido'] ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td><?= $p['cedula_identidad'] ?></td>
                            <td><?= $p['telefono'] ?></td>
                            <td><?= $p['correo'] ?: 'N/A' ?></td>
                            <td class="actions-cell">
                                <button class="btn-icon edit" onclick="abrirModalEditar(<?= htmlspecialchars(json_encode($p)) ?>)">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <button class="btn-icon delete" onclick="confirmarEliminacion(<?= $p['id'] ?>)">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<div id="modalPaciente" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class='bx bx-user-plus'></i> Registrar Nuevo Paciente</h3>
            <button class="close-btn" onclick="cerrarModal()"><i class='bx bx-x'></i></button>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=pacientes/guardar" method="POST" class="modal-body">

            <div class="form-group full-width">
                <label>Cédula *</label>
                <input type="text" name="cedula" placeholder="10 dígitos" required maxlength="10">
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="col">
                    <label>Apellido *</label>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Fecha de Nacimiento *</label>
                <input type="date" name="fecha_nacimiento" required>
            </div>

            <div class="form-group full-width">
                <label>Teléfono *</label>
                <input type="text" name="telefono" placeholder="09XXXXXXXX" required>
            </div>

            <div class="form-group full-width">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" placeholder="correo@ejemplo.com">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Registrar</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditarPaciente" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class='bx bx-edit-alt'></i> Editar Paciente</h3>
            <button class="close-btn" onclick="cerrarModalEditar()"><i class='bx bx-x'></i></button>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=pacientes/actualizar" method="POST" class="modal-body">
            <input type="hidden" name="id" id="edit_id">

            <div class="form-group full-width">
                <label>Cédula *</label>
                <input type="text" name="cedula" id="edit_cedula" placeholder="10 dígitos" required maxlength="10">
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" id="edit_nombre" required>
                </div>
                <div class="col">
                    <label>Apellido *</label>
                    <input type="text" name="apellido" id="edit_apellido" required>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Fecha de Nacimiento *</label>
                <input type="date" name="fecha_nacimiento" id="edit_fecha_nacimiento" required>
            </div>

            <div class="form-group full-width">
                <label>Teléfono *</label>
                <input type="text" name="telefono" id="edit_telefono" required>
            </div>

            <div class="form-group full-width">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" id="edit_correo">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="cerrarModalEditar()">Cancelar</button>
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
    const URL_BASE = "<?= URL_BASE ?>";
</script>

<script src="<?= URL_BASE ?>js/paciente.js"></script>


<?php require_once 'layouts/footer.php'; ?>