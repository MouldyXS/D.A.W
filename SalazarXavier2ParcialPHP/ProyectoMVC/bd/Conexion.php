<?php

class Conexion {
    private static $instance = null;
    private $host = 'localhost';
    private $bd = 'sistema_usuarios';
    private $usuario = 'root';
    private $contrasena = '';
    private $conexion;


    private function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->bd . ";charset=utf8",
                $this->usuario,
                $this->contrasena
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }


    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Conexion();
        }
        return self::$instance;
    }


    public function getConexion() {
        return $this->conexion;
    }

    public function __clone() {}

    public function __wakeup() {}
}
?>
