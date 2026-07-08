<?php
// /app/controller/CitaController.php
require_once '../app/models/Cita.php';
require_once '../app/models/Paciente.php';
require_once '../app/models/Medico.php'; // Agregamos el modelo

class CitaController {
    
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        $citas = Cita::listarTodas();
        $estadisticas = Cita::obtenerEstadisticas();
        $pacientes = Paciente::listarTodos();
        $medicos = Medico::listarTodos(); // Traemos los médicos de la BD

        require_once '../app/views/citas.php';
    }

    public function guardar() {
        session_start();
        $datos = [
            'paciente_id'    => $_POST['paciente_id'],
            'medico_id'      => $_POST['medico_id'],
            'fecha'          => $_POST['fecha'],
            'hora'           => $_POST['hora'],
            'motivo'         => $_POST['motivo'],
            'registrado_por' => $_SESSION['usuario_id'],
            'estado'         => $_POST['estado'] ?? 'Pendiente'
        ];
        Cita::registrar($datos);
        header('Location: ' . URL_BASE . 'index.php?url=citas');
    }

    public function actualizar() {
        $datos = [
            'id'        => $_POST['id'],
            'medico_id' => $_POST['medico_id'],
            'fecha'     => $_POST['fecha'],
            'hora'      => $_POST['hora'],
            'motivo'    => $_POST['motivo'],
            'estado'    => $_POST['estado']
        ];
        Cita::actualizar($datos);
        header('Location: ' . URL_BASE . 'index.php?url=citas');
    }

    public function cancelar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Cita::cambiarEstado($id, 'Cancelada');
        }
        header('Location: ' . URL_BASE . 'index.php?url=citas');
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Cita::eliminar($id);
        }
        header('Location: ' . URL_BASE . 'index.php?url=citas');
    }
}