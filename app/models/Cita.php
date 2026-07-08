<?php
require_once '../app/config/config.php';

class Cita
{

    // Obtene citas
    public static function listarTodas()
    {
        $db = Database::conectar();
        $sql = "SELECT cm.*, 
                       p.nombre as paciente_nombre, p.apellido as paciente_apellido, p.cedula_identidad,
                       m.nombre as medico_nombre, m.apellido as medico_apellido, m.especialidad
                FROM citas_medicas cm
                INNER JOIN pacientes p ON cm.paciente_id = p.id
                INNER JOIN medicos m ON cm.medico_id = m.id
                ORDER BY cm.fecha DESC, cm.hora DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    // Indicadores
    public static function obtenerEstadisticas()
    {
        $db = Database::conectar();
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN estado = 'Confirmada' THEN 1 ELSE 0 END) as confirmadas,
                SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) as pendientes,
                SUM(CASE WHEN estado = 'Cancelada' THEN 1 ELSE 0 END) as canceladas
                FROM citas_medicas";
        return $db->query($sql)->fetch();
    }

    //Registro
    public static function registrar($datos)
    {
        $db = Database::conectar();
        $sql = "INSERT INTO citas_medicas (paciente_id, medico_id, fecha, hora, motivo, registrado_por, estado) 
                VALUES (:paciente_id, :medico_id, :fecha, :hora, :motivo, :registrado_por, :estado)";
        $stmt = $db->prepare($sql);
        return $stmt->execute($datos);
    }

    //Actualizar
    public static function actualizar($datos)
    {
        $db = Database::conectar();
        $sql = "UPDATE citas_medicas SET 
                medico_id = :medico_id, 
                fecha = :fecha, 
                hora = :hora, 
                motivo = :motivo, 
                estado = :estado 
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($datos);
    }

    //Estado
    public static function cambiarEstado($id, $nuevoEstado)
    {
        $db = Database::conectar();
        $stmt = $db->prepare("UPDATE citas_medicas SET estado = :estado WHERE id = :id");
        return $stmt->execute(['estado' => $nuevoEstado, 'id' => $id]);
    }

    //Eliminar
    public static function eliminar($id)
    {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM citas_medicas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
