<section class="table-section">
    <h2>Lista de Usuarios</h2>
    
    <div id="alerts-container"></div>
    
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
            <tbody id="usuarios-tbody">
                <?php foreach ($usuarios as $usuario): ?>
                    <tr id="fila-usuario-<?php echo $usuario->id; ?>">
                        <td><?php echo htmlspecialchars($usuario->id); ?></td>
                        <td><?php echo htmlspecialchars($usuario->nombre); ?></td>
                        <td><?php echo htmlspecialchars($usuario->email); ?></td>
                        <td><?php echo htmlspecialchars($usuario->telefono ?? ''); ?></td>
                        <td class="acciones">
                            <a href="<?php echo BASE . 'index.php?action=editar&id=' . $usuario->id; ?>" class="btn-accion btn-editar">Editar</a>
                            <button class="btn-accion btn-eliminar btn-eliminar-ajax" data-id="<?php echo $usuario->id; ?>" data-nombre="<?php echo htmlspecialchars($usuario->nombre); ?>">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="mensaje-vacio">No hay usuarios registrados.</p>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const botonesEliminar = document.querySelectorAll('.btn-eliminar-ajax');
    
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function() {
            const usuarioId = this.getAttribute('data-id');
            const usuarioNombre = this.getAttribute('data-nombre');
            
            if (!confirm(`¿Está seguro de que desea eliminar a "${usuarioNombre}"?`)) {
                return;
            }
            
            this.disabled = true;
            this.textContent = 'Eliminando...';
            
            fetch('<?php echo BASE; ?>ajax_eliminar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(usuarioId)
            })
            .then(response => response.json())
            .then(data => {
                const alertContainer = document.getElementById('alerts-container');
                
                if (data.success) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success';
                    alertDiv.textContent = data.message;
                    alertContainer.innerHTML = '';
                    alertContainer.appendChild(alertDiv);
                    
                    const fila = document.getElementById('fila-usuario-' + usuarioId);
                    fila.style.transition = 'opacity 0.3s ease-out';
                    fila.style.opacity = '0';
                    setTimeout(() => {
                        fila.remove();
                        
                        const tbody = document.getElementById('usuarios-tbody');
                        if (tbody.children.length === 0) {
                            location.reload();
                        }
                    }, 300);
                } else {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-error';
                    alertDiv.textContent = 'Error: ' + data.message;
                    alertContainer.innerHTML = '';
                    alertContainer.appendChild(alertDiv);
                    
                    this.disabled = false;
                    this.textContent = 'Eliminar';
                }
            })
            .catch(error => {
                const alertContainer = document.getElementById('alerts-container');
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-error';
                alertDiv.textContent = 'Error de conexión: ' + error.message;
                alertContainer.innerHTML = '';
                alertContainer.appendChild(alertDiv);
                
                this.disabled = false;
                this.textContent = 'Eliminar';
            });
        });
    });
});
</script>
