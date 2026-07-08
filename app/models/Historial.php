<?php
require_once '../app/config/config.php';

class Historial
{

    public static function listarTodos()
    {
        $db = Database::conectar();
        $sql = "SELECT h.*, 
                       sv.presion_arterial, sv.frecuencia_cardiaca, sv.temperatura, 
                       sv.saturacion_o2, sv.peso, sv.talla,
                       p.nombre as paciente_nombre, p.apellido as paciente_apellido, p.cedula_identidad,
                       m.nombre as medico_nombre, m.apellido as medico_apellido
                FROM historiales_clinicos h
                LEFT JOIN signos_vitales sv ON h.id = sv.historial_id
                INNER JOIN pacientes p ON h.paciente_id = p.id
                INNER JOIN medicos m ON h.medico_id = m.id
                ORDER BY h.fecha DESC, h.id DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function registrar($datos)
    {
        $db = Database::conectar();

        try {
            $db->beginTransaction();

            $sqlHistorial = "INSERT INTO historiales_clinicos 
                            (paciente_id, medico_id, fecha, antecedentes_personales, motivo_consulta, diagnostico, tratamiento_receta, observaciones) 
                            VALUES 
                            (:paciente_id, :medico_id, :fecha, :antecedentes_personales, :motivo_consulta, :diagnostico, :tratamiento_receta, :observaciones)";

            $stmtH = $db->prepare($sqlHistorial);
            $stmtH->execute([
                'paciente_id'             => $datos['paciente_id'],
                'medico_id'               => $datos['medico_id'],
                'fecha'                   => $datos['fecha'],
                'antecedentes_personales' => $datos['antecedentes_personales'],
                'motivo_consulta'         => $datos['motivo_consulta'],
                'diagnostico'             => $datos['diagnostico'],
                'tratamiento_receta'      => $datos['tratamiento_receta'],
                'observaciones'           => $datos['observaciones']
            ]);

            $historial_id = $db->lastInsertId();

            $sqlSignos = "INSERT INTO signos_vitales 
                         (historial_id, presion_arterial, frecuencia_cardiaca, temperatura, saturacion_o2, peso, talla) 
                         VALUES 
                         (:historial_id, :presion_arterial, :frecuencia_cardiaca, :temperatura, :saturacion_o2, :peso, :talla)";

            $stmtS = $db->prepare($sqlSignos);
            $stmtS->execute([
                'historial_id'        => $historial_id,
                'presion_arterial'    => $datos['presion_arterial'],
                'frecuencia_cardiaca' => $datos['frecuencia_cardiaca'],
                'temperatura'         => $datos['temperatura'],
                'saturacion_o2'       => $datos['saturacion_o2'],
                'peso'                => $datos['peso'],
                'talla'               => $datos['talla']
            ]);

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public static function actualizar($datos)
    {
        $db = Database::conectar();

        try {
            $db->beginTransaction();

            $sqlHistorial = "UPDATE historiales_clinicos SET 
                             paciente_id = :paciente_id, medico_id = :medico_id, fecha = :fecha, 
                             antecedentes_personales = :antecedentes_personales, 
                             motivo_consulta = :motivo_consulta, diagnostico = :diagnostico, 
                             tratamiento_receta = :tratamiento_receta, observaciones = :observaciones 
                             WHERE id = :id";
            $stmtH = $db->prepare($sqlHistorial);
            $stmtH->execute([
                'id'                      => $datos['id'],
                'paciente_id'             => $datos['paciente_id'],
                'medico_id'               => $datos['medico_id'],
                'fecha'                   => $datos['fecha'],
                'antecedentes_personales' => $datos['antecedentes_personales'],
                'motivo_consulta'         => $datos['motivo_consulta'],
                'diagnostico'             => $datos['diagnostico'],
                'tratamiento_receta'      => $datos['tratamiento_receta'],
                'observaciones'           => $datos['observaciones']
            ]);

            $sqlSignos = "UPDATE signos_vitales SET 
                          presion_arterial = :presion_arterial, frecuencia_cardiaca = :frecuencia_cardiaca, 
                          temperatura = :temperatura, saturacion_o2 = :saturacion_o2, 
                          peso = :peso, talla = :talla 
                          WHERE historial_id = :id";
            $stmtS = $db->prepare($sqlSignos);
            $stmtS->execute([
                'id'                  => $datos['id'],
                'presion_arterial'    => $datos['presion_arterial'],
                'frecuencia_cardiaca' => $datos['frecuencia_cardiaca'],
                'temperatura'         => $datos['temperatura'],
                'saturacion_o2'       => $datos['saturacion_o2'],
                'peso'                => $datos['peso'],
                'talla'               => $datos['talla']
            ]);

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    //Eliminar
    public static function eliminar($id)
    {
        $db = Database::conectar();

        try {
            $db->beginTransaction();

            $stmtSignos = $db->prepare("DELETE FROM signos_vitales WHERE historial_id = :id");
            $stmtSignos->execute(['id' => $id]);

            $stmtHistorial = $db->prepare("DELETE FROM historiales_clinicos WHERE id = :id");
            $stmtHistorial->execute(['id' => $id]);

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
}
