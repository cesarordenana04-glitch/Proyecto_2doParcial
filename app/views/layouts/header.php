<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Centro de Especialidades CR</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= URL_BASE ?>css/global.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>css/dashboard.css">
</head>
<body>
    <div class="app-container">
        
        <header class="topbar">
            <div class="topbar-left">
                <i class='bx bx-plus-medical logo-icon'></i>
                <span class="topbar-title">Centro de Especialidades CR</span>
            </div>
            
            <div class="topbar-right">
                <div class="avatar"><?= substr($_SESSION['usuario_nombre'], 0, 1) ?></div>
                <div class="user-info">
                    <span class="role"><?= $_SESSION['usuario_rol'] ?></span>
                    <span class="name"><?= $_SESSION['usuario_nombre'] ?></span>
                </div>
                <a href="<?= URL_BASE ?>index.php?url=logout" class="logout-btn" title="Cerrar Sesión">
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
        </header>

        <div class="app-body">