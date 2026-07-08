<?php

require_once '../app/models/Usuario.php';

class UsuarioController
{

    public function index()
    {
        require_once '../app/views/login.php';
    }

    public function procesarLogin()
    {
        $correo = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuario = Usuario::autenticar($correo, $password);

        if ($usuario) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            header('Location: ' . URL_BASE . 'index.php?url=dashboard');
            exit;
        } else {
            $error = "Credenciales incorrectas o cuenta inactiva.";
            require_once '../app/views/login.php';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . URL_BASE . 'index.php?url=login');
        exit;
    }
}
