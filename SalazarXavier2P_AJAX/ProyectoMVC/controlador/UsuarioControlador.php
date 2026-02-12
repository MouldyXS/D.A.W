<?php
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/Usuario.php';


class UsuarioControlador {
    private $usuarioDAO;


    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }


    public function consultarTodos() {
        return $this->usuarioDAO->obtenerTodos();
    }


    public function consultarPorId($id) {
        return $this->usuarioDAO->obtenerPorId($id);
    }


    public function registrar($nombre, $email, $telefono) {
        try {
            $usuario = new Usuario($nombre, $email, $telefono);
            
            if ($this->usuarioDAO->insertar($usuario)) {
                return ['success' => true, 'message' => 'Usuario registrado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al registrar usuario'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function editar($id, $nombre, $email, $telefono) {
        try {
            $usuario = new Usuario($nombre, $email, $telefono, $id);
            
            if ($this->usuarioDAO->actualizar($usuario)) {
                return ['success' => true, 'message' => 'Usuario actualizado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar usuario'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function eliminar($id) {
        try {
            if ($this->usuarioDAO->eliminar($id)) {
                return ['success' => true, 'message' => 'Usuario eliminado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al eliminar usuario'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
?>
