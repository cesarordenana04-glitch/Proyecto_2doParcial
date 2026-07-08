<?php
// /app/models/Paciente.php
require_once '../app/config/config.php';

class Paciente {
    
    // Obtener todos los pacientes ordenados por el más reciente
    public static function listarTodos() {
        $db = Database::conectar();
        $stmt = $db->query("SELECT * FROM pacientes ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    //Obtener total pacientes
    public static function contarTotal() {
        $db = Database::conectar();
        $stmt = $db->query("SELECT COUNT(*) as total FROM pacientes");
        return $stmt->fetch()['total'];
    }

    //Guardar-insertar paciente
    public static function registrar($datos) {
        $db = Database::conectar();
        
        $sql = "INSERT INTO pacientes (cedula_identidad, nombre, apellido, fecha_nacimiento, telefono, correo) 
                VALUES (:cedula, :nombre, :apellido, :fecha_nacimiento, :telefono, :correo)";
        
        $stmt = $db->prepare($sql);
        
        return $stmt->execute([
            'cedula'           => $datos['cedula'],
            'nombre'           => $datos['nombre'],
            'apellido'         => $datos['apellido'],
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'telefono'         => $datos['telefono'],
            'correo'           => $datos['correo']
        ]);
    }
    //Actualizar paciente
    public static function actualizar($datos) {
        $db = Database::conectar();
        
        $sql = "UPDATE pacientes SET 
                cedula_identidad = :cedula, 
                nombre = :nombre, 
                apellido = :apellido, 
                fecha_nacimiento = :fecha_nacimiento, 
                telefono = :telefono, 
                correo = :correo 
                WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        
        return $stmt->execute([
            'id'               => $datos['id'],
            'cedula'           => $datos['cedula'],
            'nombre'           => $datos['nombre'],
            'apellido'         => $datos['apellido'],
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'telefono'         => $datos['telefono'],
            'correo'           => $datos['correo']
        ]);
    }

    //Eliminar
    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM pacientes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}