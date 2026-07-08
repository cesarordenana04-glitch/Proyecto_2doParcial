<?php
// /app/models/Factura.php
require_once '../app/config/config.php';

class Factura
{

    public static function listarTodas()
    {
        $db = Database::conectar();
        // Añadimos p.cedula_identidad a la consulta
        $sql = "SELECT f.*, p.nombre as paciente_nombre, p.apellido as paciente_apellido, p.cedula_identidad 
                FROM facturas f
                INNER JOIN pacientes p ON f.paciente_id = p.id
                ORDER BY f.fecha_emision DESC, f.id DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function obtenerEstadisticas()
    {
        $db = Database::conectar();
        $sql = "SELECT 
                    COUNT(id) as total_emitidas,
                    SUM(CASE WHEN estado = 'Pagada' THEN 1 ELSE 0 END) as total_pagadas,
                    SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) as total_pendientes,
                    SUM(CASE WHEN estado = 'Pagada' AND fecha_emision = CURDATE() THEN total ELSE 0 END) as ingresos_hoy
                FROM facturas";
        $stmt = $db->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total_emitidas'   => $resultado['total_emitidas'] ?? 0,
            'total_pagadas'    => $resultado['total_pagadas'] ?? 0,
            'total_pendientes' => $resultado['total_pendientes'] ?? 0,
            'ingresos_hoy'     => $resultado['ingresos_hoy'] ?? 0.00
        ];
    }

    public static function registrar($datosFactura, $detalles)
    {
        $db = Database::conectar();

        try {
            $db->beginTransaction();

            // Insertamos la Factura limpia
            $sqlFactura = "INSERT INTO facturas 
                           (paciente_id, numero_comprobante, fecha_emision, forma_pago, subtotal, iva, total, estado) 
                           VALUES 
                           (:paciente_id, :numero_comprobante, :fecha_emision, :forma_pago, :subtotal, :iva, :total, :estado)";
            $stmtF = $db->prepare($sqlFactura);
            $stmtF->execute($datosFactura);

            $factura_id = $db->lastInsertId();

            // Insertamos los detalles generados en el JS
            $sqlDetalle = "INSERT INTO detalles_factura 
                           (factura_id, servicio_id, descripcion_personalizada, cantidad, precio_unitario) 
                           VALUES 
                           (:factura_id, :servicio_id, :descripcion_personalizada, :cantidad, :precio_unitario)";
            $stmtD = $db->prepare($sqlDetalle);

            foreach ($detalles as $item) {
                $stmtD->execute([
                    'factura_id'                => $factura_id,
                    'servicio_id'               => $item['servicio_id'],
                    'descripcion_personalizada' => $item['descripcion'],
                    'cantidad'                  => $item['cantidad'],
                    'precio_unitario'           => $item['precio']
                ]);
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public static function anular($id)
    {
        $db = Database::conectar();
        $stmt = $db->prepare("UPDATE facturas SET estado = 'Anulada' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
