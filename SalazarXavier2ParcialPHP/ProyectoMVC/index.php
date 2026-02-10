<?php
session_start();

define('BASE', 'http://localhost/ProyectoMVC/');


require_once __DIR__ . '/controlador/UsuarioControlador.php';

$usuarioControlador = new UsuarioControlador();


$action = isset($_GET['action']) ? $_GET['action'] : (isset($_SESSION['user']) ? 'inicio' : 'login');


switch ($action) {
    case 'consultar':
        $usuarios = $usuarioControlador->consultarTodos();
        $titulo = 'Listar Usuarios';
        ob_start();
        include 'vista/layout/header.php';
        include 'vista/usuario/consultar.php';
        break;

    case 'registrar':
        $titulo = 'Registrar Usuario';
        ob_start();
        include 'vista/layout/header.php';
        include 'vista/usuario/registrar.php';
        break;

    case 'guardar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = htmlspecialchars($_POST['nombre'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $telefono = htmlspecialchars($_POST['telefono'] ?? '');

            $resultado = $usuarioControlador->registrar($nombre, $email, $telefono);

            if ($resultado['success']) {
                header('Location: index.php?action=consultar&mensaje=Usuario registrado exitosamente');
                exit;
            } else {
                die($resultado['message']);
            }
        }
        break;

    case 'login':
        $titulo = 'Iniciar Sesión';
        ob_start();
        include 'vista/layout/header.php';
        include 'vista/login.php';
        break;

    case 'autenticar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $clave = trim($_POST['clave'] ?? '');

          
            if ($usuario === 'admin' && $clave === 'admin123') {
                $_SESSION['user'] = 'admin';
                header('Location: index.php');
                exit;
            } else {
                header('Location: index.php?action=login&error=1');
                exit;
            }
        }
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit;

    case 'editar':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id) {
            $usuario = $usuarioControlador->consultarPorId($id);
            $titulo = 'Editar Usuario';
            ob_start();
            include 'vista/layout/header.php';
            include 'vista/usuario/editar.php';
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $nombre = htmlspecialchars($_POST['nombre'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $telefono = htmlspecialchars($_POST['telefono'] ?? '');

            $resultado = $usuarioControlador->editar($id, $nombre, $email, $telefono);

            if ($resultado['success']) {
                header('Location: index.php?action=consultar&mensaje=Usuario actualizado exitosamente');
                exit;
            } else {
                die($resultado['message']);
            }
        }
        break;

    case 'eliminar':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id) {
            $resultado = $usuarioControlador->eliminar($id);

            if ($resultado['success']) {
                header('Location: index.php?action=consultar&mensaje=Usuario eliminado exitosamente');
                exit;
            } else {
                die($resultado['message']);
            }
        }
        break;

    case 'inicio':
    default:
        $usuarios = $usuarioControlador->consultarTodos();
        $titulo = 'Sistema de Gestión de Usuarios';
        ob_start();
        include 'vista/layout/header.php';
        ?>
        <section class="bienvenida">
            <h2>Bienvenido al Sistema de Gestión de Usuarios</h2>
            <p>Este sistema permite administrar usuarios de forma eficiente.</p>
            <div class="stats">
                <div class="stat-card">
                    <h3><?php echo count($usuarios); ?></h3>
                    <p>Usuarios Registrados</p>
                </div>
            </div>
            <div class="opciones">
                <a href="index.php?action=registrar" class="btn btn-primary">Registrar Nuevo Usuario</a>
                <a href="index.php?action=consultar" class="btn btn-secondary">Ver Todos los Usuarios</a>
            </div>
        </section>
        <?php
        break;
}


if (isset($_GET['mensaje'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['mensaje']) . '</div>';
}

$contenido = ob_get_clean();
echo $contenido;
?>
