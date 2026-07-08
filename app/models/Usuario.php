<?php
// /app/models/Usuario.php

require_once '../app/config/config.php';

class Usuario {
    
    public static function autenticar($correo, $password) {
        $db = Database::conectar();
        
        // Buscamos al usuario por su correo y verificamos que esté activo
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE correo = :correo AND activo = 1");
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Comparamos contraseñas (Temporalmente en texto plano)
            // TODO a futuro: if (password_verify($password, $usuario['password']))
            if ($password === $usuario['password']) {
                return $usuario; // Login exitoso
            }
        }
        
        return false; // Login fallido
    }
}