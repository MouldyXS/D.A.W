<section class="form-section">
    <h2>Editar Usuario</h2>
    
    <?php if ($usuario): ?>
        <form method="POST" action="<?php echo BASE . 'index.php?action=actualizar'; ?>">
            <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario->nombre); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario->email); ?>" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario->telefono ?? ''); ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                <a href="<?php echo BASE . 'index.php'; ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    <?php else: ?>
        <p class="mensaje-error">Usuario no encontrado.</p>
        <a href="<?php echo BASE . 'index.php'; ?>" class="btn btn-secondary">Volver</a>
    <?php endif; ?>
</section>
