<?php

define('DB_HOST', 'mysql-25362b36-gabrieleduardourgilesr-1ed4.i.aivencloud.com');
define('DB_PORT', '24536');
define('DB_NAME', 'defaultdb');
define('DB_USER', 'avnadmin');
define('DB_PASS', 'AVNS_pIUs8bYddXYtmiHKmoX');
define('DB_CHARSET', 'utf8mb4');

if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost') {
    define('URL_BASE', 'http://localhost/PROYECTO_2DOPARCIAL/public/');
} else {
    define('URL_BASE', '/'); 
}

class Database
{
    private static $conexion = null;

    public static function conectar()
    {
        if (self::$conexion === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

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