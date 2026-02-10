<section class="table-section">
    <h2>Lista de Usuarios</h2>
    
    <?php if (!empty($usuarios)): ?>
        <table class="table-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario->id); ?></td>
                        <td><?php echo htmlspecialchars($usuario->nombre); ?></td>
                        <td><?php echo htmlspecialchars($usuario->email); ?></td>
                        <td><?php echo htmlspecialchars($usuario->telefono ?? ''); ?></td>
                        <td class="acciones">
                            <a href="<?php echo BASE . 'index.php?action=editar&id=' . $usuario->id; ?>" class="btn-accion btn-editar">Editar</a>
                            <a href="<?php echo BASE . 'index.php?action=eliminar&id=' . $usuario->id; ?>" class="btn-accion btn-eliminar" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="mensaje-vacio">No hay usuarios registrados.</p>
    <?php endif; ?>
</section>
