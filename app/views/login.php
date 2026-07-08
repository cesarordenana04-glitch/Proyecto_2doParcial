<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Centro de Especialidades CR</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL_BASE ?>css/global.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>css/login.css">
</head>

<body>

    <div class="login-wrapper">

        <div class="login-sidebar">
            <div class="sidebar-content">
                <div class="logo-box">
                    <i class='bx bx-plus-medical'></i>
                </div>
                <h1>Centro de<br>Especialidades CR</h1>
                <p class="subtitle">Sistema de Gestión Médica Integral</p>

                <ul class="feature-list">
                    <li><i class='bx bxs-check-circle'></i> Gestión de Pacientes</li>
                    <li><i class='bx bxs-check-circle'></i> Citas en Línea</li>
                    <li><i class='bx bxs-check-circle'></i> Historial Clínico</li>
                    <li><i class='bx bxs-check-circle'></i> Facturación Digital</li>
                </ul>
            </div>

            <div class="sidebar-footer">
                Universidad de Guayaquil - DAW 2026
            </div>

            <div class="circle circle-top"></div>
            <div class="circle circle-bottom"></div>
        </div>

        <div class="login-main">
            <div class="login-card">
                <h2>Bienvenido de nuevo</h2>
                <p class="login-instructions">Ingresa tus credenciales para continuar</p>

                <?php if (isset($error)): ?>
                    <div class="alert-error">
                        <i class='bx bx-error-circle'></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <form action="<?= URL_BASE ?>index.php?url=login" method="POST">
                    <div class="input-group">
                        <i class='bx bx-envelope icon-left'></i>
                        <input type="email" name="correo" placeholder="Correo electrónico" required>
                    </div>

                    <div class="input-group">
                        <i class='bx bx-lock-alt icon-left'></i>
                        <input type="password" name="password" id="password" placeholder="Contraseña" required>
                        <i class='bx bx-show icon-right toggle-password' id="togglePassword"></i>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class='bx bx-log-in'></i> Iniciar Sesión
                    </button>
                </form>

                <div class="login-footer-text">
                    <small>Correo: <strong>Admin@gmail.com</strong> - Clave: <strong>Admin1234</strong></small>
                </div>
            </div>
        </div>

    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bx-show');
            this.classList.toggle('bx-hide');
        });
    </script>
</body>

</html>