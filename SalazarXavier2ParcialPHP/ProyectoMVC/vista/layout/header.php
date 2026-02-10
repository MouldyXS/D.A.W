<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo) ? $titulo : 'Sistema de Gestión de Usuarios'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE . 'css/styles.css'; ?>">
</head>
<body>
    <header>
        <div class="container-header">
            <h1>Sistema de Gestión de Usuarios</h1>
            <p class="subtitle">administración sencillo de usuarios</p>
        </div>
    </header>

    <?php include __DIR__ . '/menu.php'; ?>

    <main>
