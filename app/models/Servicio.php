<?php

require_once '../app/config/config.php';

class Servicio {
    public static function listarActivos() {
        $db = Database::conectar();
        $stmt = $db->query("SELECT * FROM servicios WHERE activo = 1 ORDER BY tipo ASC, nombre ASC");
        return $stmt->fetchAll();
    }
}