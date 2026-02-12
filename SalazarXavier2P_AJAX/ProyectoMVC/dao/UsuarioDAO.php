<?php
require_once __DIR__ . '/../bd/Conexion.php';
require_once __DIR__ . '/../modelo/Usuario.php';


class UsuarioDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getInstance()->getConexion();
    }

    public function obtenerTodos() {
        try {
            $sql = "SELECT * FROM usuarios ORDER BY id DESC";
            $stmt = $this->conexion->query($sql);
            $usuarios = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario = new Usuario(
                    $row['nombre'],
                    $row['email'],
                    $row['telefono'],
                    $row['id']
                );
                $usuario->created_at = $row['created_at'];
                $usuario->updated_at = $row['updated_at'];
                $usuarios[] = $usuario;
            }

            return $usuarios;
        } catch (PDOException $e) {
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario = new Usuario(
                    $row['nombre'],
                    $row['email'],
                    $row['telefono'],
                    $row['id']
                );
                $usuario->created_at = $row['created_at'];
                $usuario->updated_at = $row['updated_at'];
                return $usuario;
            }

            return null;
        } catch (PDOException $e) {
            die("Error al obtener usuario: " . $e->getMessage());
        }
    }

    public function existeEmail($email, $idExcluir = null) {
        try {
            $sql = "SELECT COUNT(*) as count FROM usuarios WHERE email = ?";
            if ($idExcluir !== null) {
                $sql .= " AND id != ?";
            }
            $stmt = $this->conexion->prepare($sql);
            
            if ($idExcluir !== null) {
                $stmt->execute([$email, $idExcluir]);
            } else {
                $stmt->execute([$email]);
            }
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['count'] > 0;
        } catch (PDOException $e) {
            throw new Exception("Error al verificar email: " . $e->getMessage());
        }
    }

    public function insertar(Usuario $usuario) {
        try {
            // Validar que el email no exista
            if ($this->existeEmail($usuario->email)) {
                throw new Exception("El email '{$usuario->email}' ya está registrado");
            }
            
            $sql = "INSERT INTO usuarios (nombre, email, telefono) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$usuario->nombre, $usuario->email, $usuario->telefono]);
        } catch (PDOException $e) {
            throw new Exception("Error al insertar usuario: " . $e->getMessage());
        }
    }


    public function actualizar(Usuario $usuario) {
        try {
            // Validar que el email no exista (excluyendo el usuario actual)
            if ($this->existeEmail($usuario->email, $usuario->id)) {
                throw new Exception("El email '{$usuario->email}' ya está registrado por otro usuario");
            }
            
            $sql = "UPDATE usuarios SET nombre = ?, email = ?, telefono = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$usuario->nombre, $usuario->email, $usuario->telefono, $usuario->id]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar usuario: " . $e->getMessage());
        }
    }


    public function eliminar($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar usuario: " . $e->getMessage());
        }
    }
}
?>
