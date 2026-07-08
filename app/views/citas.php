<?php require_once 'layouts/header.php'; ?>
<?php require_once 'layouts/sidebar.php'; ?>

<?php
/**
 * @var array $citas 
 * @var array $estadisticas 
 * @var array $pacientes 
 * @var array $medicos
 */
?>

<link rel="stylesheet" href="<?= URL_BASE ?>css/pacientes.css">
<link rel="stylesheet" href="<?= URL_BASE ?>css/citas.css">

<div class="page-content">

    <div class="page-header">
        <div class="page-title">
            <i class='bx bx-calendar-check'></i>
            <div>
                <h2>Módulo de Agendar Citas</h2>
                <p>Programar, modificar o cancelar turnos de pacientes — Recepción / Administración</p>
            </div>
        </div>
        <button class="btn-primary" onclick="abrirModal()">
            <i class='bx bx-plus'></i> Nueva Cita
        </button>
    </div>

    <div class="indicator-cards">
        <div class="card-stat">
            <i class='bx bx-calendar' style="color: #0d9488; background: #ccfbf1;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['total'] ?? 0 ?></h3>
                <p>Total Citas</p>
            </div>
        </div>
        <div class="card-stat">
            <i class='bx bx-check-circle' style="color: #16a34a; background: #dcfce7;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['confirmadas'] ?? 0 ?></h3>
                <p>Confirmadas</p>
            </div>
        </div>
        <div class="card-stat">
            <i class='bx bx-time-five' style="color: #ea580c; background: #ffedd5;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['pendientes'] ?? 0 ?></h3>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="card-stat">
            <i class='bx bx-x-circle' style="color: #dc2626; background: #fee2e2;"></i>
            <div class="stat-info">
                <h3><?= $estadisticas['canceladas'] ?? 0 ?></h3>
                <p>Canceladas</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>PACIENTE</th>
                    <th>CÉDULA</th>
                    <th>MÉDICO</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>MOTIVO</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($citas)): ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">No hay citas agendadas.</td>
                    </tr>
                <?php else: ?>
                    <?php $contador = 1;
                    foreach ($citas as $c): ?>
                        <tr>
                            <td><?= $contador++ ?></td>
                            <td>
                                <strong><?= $c['paciente_nombre'] . ' ' . $c['paciente_apellido'] ?></strong>
                            </td>
                            <td><?= $c['cedula_identidad'] ?></td>
                            <td>Dr(a). <?= $c['medico_nombre'] . ' ' . $c['medico_apellido'] ?> &mdash; <small><?= $c['especialidad'] ?></small></td>
                            <td><?= $c['fecha'] ?></td>
                            <td><?= substr($c['hora'], 0, 5) ?></td>
                            <td><?= $c['motivo'] ?></td>
                            <td>
                                <span class="badge badge-<?= strtolower($c['estado']) ?>"><?= $c['estado'] ?></span>
                            </td>
                            <td class="actions-cell">
                                <button class="btn-icon edit" onclick='abrirModalEditar(<?= json_encode($c) ?>)' title="Editar">
                                    <i class='bx bx-edit-alt'></i>
                                </button>

                                <?php if ($c['estado'] !== 'Cancelada'): ?>
                                    <button class="btn-icon cancel" onclick="confirmarCancelacion(<?= $c['id'] ?>)" title="Cancelar Cita">
                                        <i class='bx bx-x'></i>
                                    </button>
                                <?php endif; ?>

                                <button class="btn-icon delete" onclick="confirmarEliminacion(<?= $c['id'] ?>)" title="Eliminar">
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

<div id="modalCita" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class='bx bx-calendar-plus'></i> Agendar Nueva Cita</h3>
            <button class="close-btn" onclick="cerrarModal()"><i class='bx bx-x'></i></button>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=citas/guardar" method="POST" class="modal-body">

            <div class="form-group full-width">
                <label>Seleccionar Paciente *</label>
                <select name="paciente_id" required>
                    <option value="">-- Seleccione un paciente --</option>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nombre'] . ' ' . $p['apellido'] ?> (CI: <?= $p['cedula_identidad'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Seleccionar Médico y Especialidad *</label>
                <select name="medico_id" required>
                    <option value="">-- Seleccione un médico --</option>
                    <?php foreach ($medicos as $m): ?>
                        <option value="<?= $m['id'] ?>">Dr(a). <?= $m['nombre'] . ' ' . $m['apellido'] ?> &mdash; <?= $m['especialidad'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Fecha *</label>
                    <input type="date" name="fecha" required>
                </div>
                <div class="col">
                    <label>Hora *</label>
                    <input type="time" name="hora" required>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Motivo de la Consulta *</label>
                <input type="text" name="motivo" placeholder="Ej. Control de presión arterial" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Agendar Cita</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditarCita" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class='bx bx-edit-alt'></i> Modificar Cita Médica</h3>
            <button class="close-btn" onclick="cerrarModalEditar()"><i class='bx bx-x'></i></button>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=citas/actualizar" method="POST" class="modal-body">
            <input type="hidden" name="id" id="edit_cita_id">

            <div class="form-group full-width">
                <label>Paciente</label>
                <input type="text" id="edit_paciente_nombre" readonly style="background-color: #f1f5f9; color: #64748b;">
            </div>

            <div class="form-group full-width">
                <label>Asignar Médico *</label>
                <select name="medico_id" id="edit_medico_id" required>
                    <?php foreach ($medicos as $m): ?>
                        <option value="<?= $m['id'] ?>">Dr(a). <?= $m['nombre'] . ' ' . $m['apellido'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Fecha *</label>
                    <input type="date" name="fecha" id="edit_fecha" required>
                </div>
                <div class="col">
                    <label>Hora *</label>
                    <input type="time" name="hora" id="edit_hora" required>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Motivo *</label>
                <input type="text" name="motivo" id="edit_motivo" required>
            </div>

            <div class="form-group full-width">
                <label>Estado de la Cita *</label>
                <select name="estado" id="edit_estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Atendida">Atendida</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
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
<script src="<?= URL_BASE ?>js/citas.js"></script>

<?php require_once 'layouts/footer.php'; ?>