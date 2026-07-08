<?php

require_once '../app/models/Historial.php';
require_once '../app/models/Paciente.php';
require_once '../app/models/Medico.php';

class HistorialController
{

    public function index()
    {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        $historiales = Historial::listarTodos();
        $pacientes = Paciente::listarTodos();
        $medicos = Medico::listarTodos();

        require_once '../app/views/historial.php';
    }

    public function guardar()
    {
        $datos = [
            'paciente_id'             => $_POST['paciente_id'],
            'medico_id'               => $_POST['medico_id'],
            'fecha'                   => $_POST['fecha'],
            'antecedentes_personales' => $_POST['antecedentes_personales'],
            'motivo_consulta'         => $_POST['motivo_consulta'],
            'diagnostico'             => $_POST['diagnostico'],
            'tratamiento_receta'      => $_POST['tratamiento_receta'],
            'observaciones'           => $_POST['observaciones'],
            // Signos vitales
            'presion_arterial'        => $_POST['presion_arterial'],
            'frecuencia_cardiaca'     => $_POST['frecuencia_cardiaca'],
            'temperatura'             => $_POST['temperatura'],
            'saturacion_o2'           => $_POST['saturacion_o2'],
            'peso'                    => $_POST['peso'],
            'talla'                   => $_POST['talla']
        ];

        Historial::registrar($datos);
        header('Location: ' . URL_BASE . 'index.php?url=historial');
    }

    public function actualizar()
    {
        $datos = [
            'id'                      => $_POST['id'],
            'paciente_id'             => $_POST['paciente_id'],
            'medico_id'               => $_POST['medico_id'],
            'fecha'                   => $_POST['fecha'],
            'antecedentes_personales' => $_POST['antecedentes_personales'],
            'motivo_consulta'         => $_POST['motivo_consulta'],
            'diagnostico'             => $_POST['diagnostico'],
            'tratamiento_receta'      => $_POST['tratamiento_receta'],
            'observaciones'           => $_POST['observaciones'],
            // Signos vitales
            'presion_arterial'        => $_POST['presion_arterial'],
            'frecuencia_cardiaca'     => $_POST['frecuencia_cardiaca'],
            'temperatura'             => $_POST['temperatura'],
            'saturacion_o2'           => $_POST['saturacion_o2'],
            'peso'                    => $_POST['peso'],
            'talla'                   => $_POST['talla']
        ];

        Historial::actualizar($datos);
        header('Location: ' . URL_BASE . 'index.php?url=historial');
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Historial::eliminar($id);
        }
        header('Location: ' . URL_BASE . 'index.php?url=historial');
        exit;
    }
}
