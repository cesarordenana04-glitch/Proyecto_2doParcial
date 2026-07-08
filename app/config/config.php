<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'hospital');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('URL_BASE', 'http://localhost/PROYECTO_2DOPARCIAL/public/');

class Database
{
    private static $conexion = null;

    public static function conectar()
    {
        if (self::$conexion === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

                $opciones = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$conexion = new PDO($dsn, DB_USER, DB_PASS, $opciones);
            } catch (PDOException $e) {
                die("Error crítico de conexión en el Hospital de Especialidades: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }
}