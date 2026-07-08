<?php require_once 'layouts/header.php'; ?>
<?php require_once 'layouts/sidebar.php'; ?>

<div class="dashboard-wrapper">
    <div class="welcome-card">
        <div class="welcome-icon">
            <i class='bx bx-plus-medical'></i>
        </div>
        <h2>Bienvenido, <?= $_SESSION['usuario_nombre'] ?></h2>
        <p>Selecciona un módulo del menú lateral para comenzar.</p>

        <div class="modules-grid">
            <a href="<?= URL_BASE ?>index.php?url=pacientes" class="module-box">
                <i class='bx bx-group'></i>
                <span>Pacientes</span>
            </a>
            
            <a href="<?= URL_BASE ?>index.php?url=citas" class="module-box">
                <i class='bx bx-calendar-check'></i>
                <span>Citas</span>
            </a>
            
            <a href="<?= URL_BASE ?>index.php?url=historial" class="module-box">
                <i class='bx bx-folder-open'></i>
                <span>Historial</span>
            </a>
            
            <a href="<?= URL_BASE ?>index.php?url=facturacion" class="module-box">
                <i class='bx bx-receipt'></i>
                <span>Facturación</span>
            </a>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>