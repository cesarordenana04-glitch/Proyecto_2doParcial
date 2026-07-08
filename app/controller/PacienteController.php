<?php
// /app/controller/PacienteController.php
require_once '../app/models/Paciente.php';

class PacienteController {
    
    public function index() {
        session_start();
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        $pacientes = Paciente::listarTodos();
        $totalPacientes = Paciente::contarTotal();
        require_once '../app/views/pacientes.php';
    }

    //Guardar(Insert)
    public function guardar() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        $datos = [
            'cedula'           => $_POST['cedula'] ?? '',
            'nombre'           => $_POST['nombre'] ?? '',
            'apellido'         => $_POST['apellido'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
            'telefono'         => $_POST['telefono'] ?? '',
            'correo'           => $_POST['correo'] ?? ''
        ];

        Paciente::registrar($datos);

        header('Location: ' . URL_BASE . 'index.php?url=pacientes');
        exit;
    }

    //Editar
    public function actualizar() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        $datos = [
            'id'               => $_POST['id'] ?? '',
            'cedula'           => $_POST['cedula'] ?? '',
            'nombre'           => $_POST['nombre'] ?? '',
            'apellido'         => $_POST['apellido'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
            'telefono'         => $_POST['telefono'] ?? '',
            'correo'           => $_POST['correo'] ?? ''
        ];

        Paciente::actualizar($datos);

        header('Location: ' . URL_BASE . 'index.php?url=pacientes');
        exit;
    }

    //Borrar
    public function eliminar() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        // Recibimos el ID por la URL (método GET)
        $id = $_GET['id'] ?? null;

        if ($id) {
            Paciente::eliminar($id);
        }

        header('Location: ' . URL_BASE . 'index.php?url=pacientes');
        exit;
    }
}