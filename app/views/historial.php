<?php require_once 'layouts/header.php'; ?>
<?php require_once 'layouts/sidebar.php'; ?>

<?php
/**
 * @var array $historiales 
 * @var array $pacientes 
 * @var array $medicos
 */
?>

<link rel="stylesheet" href="<?= URL_BASE ?>css/pacientes.css">
<link rel="stylesheet" href="<?= URL_BASE ?>css/historial.css">

<div class="page-content">

    <div class="page-header">
        <div class="page-title">
            <i class='bx bx-book-bookmark'></i>
            <div>
                <h2>Historial Clínico</h2>
                <p>Expediente digital del paciente — signos vitales, antecedentes, diagnósticos y recetas</p>
            </div>
        </div>
        <button class="btn-primary" id="btnNuevaConsulta">
            <i class='bx bx-plus'></i> Nuevo Registro
        </button>
    </div>

    <div class="search-bar">
        <i class='bx bx-search'></i>
        <input type="text" id="buscadorHistorial" placeholder="Buscar por nombre o cédula...">
    </div>

    <div class="form-panel" id="panelNuevaConsulta" style="display: none;">
        <div class="panel-header">
            <h3><i class='bx bx-file-blank'></i> Registrar Consulta Médica</h3>
            <button class="close-btn" id="btnCerrarNuevaConsulta"><i class='bx bx-x'></i></button>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=historial/guardar" method="POST" class="panel-body">

            <div class="form-group row">
                <div class="col">
                    <label>Paciente *</label>
                    <select name="paciente_id" id="select_paciente_nuevo" required>
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
                    <input type="text" id="input_cedula_nuevo" readonly class="readonly-input">
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Médico Responsable *</label>
                    <select name="medico_id" required>
                        <option value="">-- Seleccione un médico --</option>
                        <?php foreach ($medicos as $m): ?>
                            <option value="<?= $m['id'] ?>">Dr(a). <?= $m['nombre'] . ' ' . $m['apellido'] ?> — <?= $m['especialidad'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label>Fecha *</label>
                    <input type="date" name="fecha" required>
                </div>
            </div>

            <h4 class="section-title"><i class='bx bx-pulse'></i> Signos Vitales</h4>
            <div class="form-group grid-3">
                <div class="col">
                    <label>Presión Arterial</label>
                    <input type="text" name="presion_arterial" placeholder="Ej. 120/80 mmHg">
                </div>
                <div class="col">
                    <label>Frecuencia Cardíaca</label>
                    <input type="text" name="frecuencia_cardiaca" placeholder="Ej. 72 bpm">
                </div>
                <div class="col">
                    <label>Temperatura</label>
                    <input type="text" name="temperatura" placeholder="Ej. 36.5 °C">
                </div>
                <div class="col">
                    <label>Saturación O2</label>
                    <input type="text" name="saturacion_o2" placeholder="Ej. 98%">
                </div>
                <div class="col">
                    <label>Peso</label>
                    <input type="text" name="peso" placeholder="Ej. 70 kg">
                </div>
                <div class="col">
                    <label>Talla</label>
                    <input type="text" name="talla" placeholder="Ej. 170 cm">
                </div>
            </div>

            <h4 class="section-title"><i class='bx bx-history'></i> Antecedentes y Diagnóstico</h4>
            <div class="form-group full-width">
                <label>Antecedentes Personales</label>
                <textarea name="antecedentes_personales" rows="2" placeholder="Enfermedades previas, alergias, cirugías..."></textarea>
            </div>
            <div class="form-group full-width">
                <label>Motivo de Consulta *</label>
                <textarea name="motivo_consulta" rows="2" required placeholder="Síntomas que presenta el paciente..."></textarea>
            </div>
            <div class="form-group full-width">
                <label>Diagnóstico *</label>
                <textarea name="diagnostico" rows="2" required placeholder="Diagnóstico médico..."></textarea>
            </div>
            <div class="form-group full-width">
                <label>Tratamiento / Receta *</label>
                <textarea name="tratamiento_receta" rows="3" required placeholder="Medicamentos, dosis, indicaciones..."></textarea>
            </div>
            <div class="form-group full-width">
                <label>Observaciones</label>
                <textarea name="observaciones" rows="2" placeholder="Notas adicionales..."></textarea>
            </div>

            <div class="panel-footer">
                <button type="button" class="btn-secondary" id="btnCancelarNueva">Cancelar</button>
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Guardar Consulta</button>
            </div>
        </form>
    </div>

    <div class="form-panel edit-panel" id="panelEditarConsulta" style="display: none;">
        <div class="panel-header">
            <h3><i class='bx bx-edit'></i> Modificar Consulta Médica</h3>
            <button class="close-btn" id="btnCerrarEditarConsulta"><i class='bx bx-x'></i></button>
        </div>

        <form action="<?= URL_BASE ?>index.php?url=historial/actualizar" method="POST" class="panel-body" id="formEditarHistorial">
            <input type="hidden" name="id" id="edit_historial_id">
            <div class="form-group row">
                <div class="col">
                    <label>Paciente *</label>
                    <select name="paciente_id" id="edit_paciente_id" required>
                        <?php foreach ($pacientes as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= $p['nombre'] . ' ' . $p['apellido'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label>Médico Responsable *</label>
                    <select name="medico_id" id="edit_medico_id" required>
                        <?php foreach ($medicos as $m): ?>
                            <option value="<?= $m['id'] ?>">Dr(a). <?= $m['nombre'] . ' ' . $m['apellido'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label>Fecha *</label>
                    <input type="date" name="fecha" id="edit_fecha" required>
                </div>
            </div>

            <div class="form-group grid-3">
                <div class="col"><label>Presión Arterial</label><input type="text" name="presion_arterial" id="edit_presion"></div>
                <div class="col"><label>Frecuencia Cardíaca</label><input type="text" name="frecuencia_cardiaca" id="edit_fc"></div>
                <div class="col"><label>Temperatura</label><input type="text" name="temperatura" id="edit_temp"></div>
                <div class="col"><label>Saturación O2</label><input type="text" name="saturacion_o2" id="edit_sat"></div>
                <div class="col"><label>Peso</label><input type="text" name="peso" id="edit_peso"></div>
                <div class="col"><label>Talla</label><input type="text" name="talla" id="edit_talla"></div>
            </div>

            <div class="form-group full-width"><label>Antecedentes</label><textarea name="antecedentes_personales" id="edit_antecedentes" rows="2"></textarea></div>
            <div class="form-group full-width"><label>Motivo de Consulta *</label><textarea name="motivo_consulta" id="edit_motivo" rows="2" required></textarea></div>
            <div class="form-group full-width"><label>Diagnóstico *</label><textarea name="diagnostico" id="edit_diagnostico" rows="2" required></textarea></div>
            <div class="form-group full-width"><label>Tratamiento / Receta *</label><textarea name="tratamiento_receta" id="edit_tratamiento" rows="3" required></textarea></div>
            <div class="form-group full-width"><label>Observaciones</label><textarea name="observaciones" id="edit_observaciones" rows="2"></textarea></div>

            <div class="panel-footer">
                <button type="button" class="btn-secondary" id="btnCancelarEditar">Cancelar</button>
                <button type="submit" class="btn-primary"><i class='bx bx-save'></i> Guardar Cambios</button>
            </div>
        </form>
    </div>

    <div class="accordion-container">

        <?php if (empty($historiales)): ?>
            <div class="empty-state">
                <p>No hay consultas médicas registradas en el historial.</p>
            </div>
        <?php else: ?>

            <?php foreach ($historiales as $h): ?>
                <div class="accordion-card fila-historial">

                    <div class="accordion-header">
                        <div class="patient-info-mini">
                            <div class="avatar-circle"><?= substr($h['paciente_nombre'], 0, 1) ?></div>
                            <div class="details">
                                <span class="name-text"><?= $h['paciente_nombre'] . ' ' . $h['paciente_apellido'] ?></span>
                                <span class="ci-text">CI: <?= $h['cedula_identidad'] ?></span>
                            </div>
                        </div>

                        <div class="meta-info">
                            <span><i class='bx bx-calendar'></i> <?= $h['fecha'] ?></span>
                            <span><i class='bx bx-user'></i> Dr(a). <?= $h['medico_apellido'] ?></span>
                        </div>

                        <div class="action-toggle">
                            <button class="btn-toggle-accordion"><i class='bx bx-chevron-down'></i></button>
                        </div>
                    </div>

                    <div class="accordion-body">

                        <div class="vital-signs-bar">
                            <div class="vital-card"><i class='bx bxs-heart'></i><strong><?= $h['presion_arterial'] ?: '--' ?></strong><span>Presión</span></div>
                            <div class="vital-card"><i class='bx bx-pulse'></i><strong><?= $h['frecuencia_cardiaca'] ?: '--' ?></strong><span>F. Cardíaca</span></div>
                            <div class="vital-card"><i class='bx bxs-thermometer'></i><strong><?= $h['temperatura'] ?: '--' ?></strong><span>Temp.</span></div>
                            <div class="vital-card"><i class='bx bx-wind'></i><strong><?= $h['saturacion_o2'] ?: '--' ?></strong><span>Sat. O2</span></div>
                            <div class="vital-card"><i class='bx bx-dumbbell'></i><strong><?= $h['peso'] ?: '--' ?></strong><span>Peso</span></div>
                            <div class="vital-card"><i class='bx bx-ruler'></i><strong><?= $h['talla'] ?: '--' ?></strong><span>Talla</span></div>
                        </div>

                        <div class="clinical-details-grid">
                            <div class="clinical-block">
                                <h6>ANTECEDENTES</h6>
                                <p><?= $h['antecedentes_personales'] ?: 'Sin registro.' ?></p>
                            </div>
                            <div class="clinical-block">
                                <h6>MOTIVO DE CONSULTA</h6>
                                <p><?= $h['motivo_consulta'] ?></p>
                            </div>
                            <div class="clinical-block full-width">
                                <h6>DIAGNÓSTICO</h6>
                                <p><?= $h['diagnostico'] ?></p>
                            </div>
                            <div class="clinical-block full-width highlight-block">
                                <h6><i class='bx bx-receipt'></i> RECETA / TRATAMIENTO</h6>
                                <p><?= $h['tratamiento_receta'] ?></p>
                            </div>
                            <div class="clinical-block full-width">
                                <h6>OBSERVACIONES</h6>
                                <p><?= $h['observaciones'] ?: 'Ninguna.' ?></p>
                            </div>
                        </div>

                        <div class="accordion-footer">
                            <div class="left-actions">
                                <button class="btn-text edit-btn" onclick='abrirEdicionHistorial(<?= htmlspecialchars(json_encode($h), ENT_QUOTES, 'UTF-8') ?>)'>
                                    <i class='bx bx-edit'></i> Editar
                                </button>
                                <button type="button" class="btn-text delete-btn" onclick="confirmarEliminacionHistorial(<?= $h['id'] ?>)">
                                    <i class='bx bx-trash'></i> Eliminar
                                </button>
                            </div>
                            <button class="btn-outline toggle-hide-btn">
                                <i class='bx bx-hide'></i> Ocultar
                            </button>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>

<script>
    const URL_BASE = "<?= URL_BASE ?>";
</script>

<script src="<?= URL_BASE ?>js/historial.js"></script>

<?php require_once 'layouts/footer.php'; ?>