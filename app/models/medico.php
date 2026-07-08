<?php

require_once '../app/config/config.php';

class Medico {
    public static function listarTodos() {
        $db = Database::conectar();
        $stmt = $db->query("SELECT * FROM medicos ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }
}